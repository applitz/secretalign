<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Classifies orthodontic images into the standard record slots using a vision
 * LLM (Google Gemini) via OpenRouter.
 *
 * Two passes:
 *   Pass 1 - classify every image individually, in parallel.
 *   Pass 2 - for the images labelled as a "Buccal" view, compare them as a pair
 *            to reliably assign Right vs Left (single images can't tell reliably).
 *
 * Input images are expected to already be small (resized client-side to ~768px)
 * base64 data URIs, e.g. "data:image/jpeg;base64,....".
 */
class ImageClassifierService
{
    /** The 11 slots an image can be classified into (must match the UI dropdown). */
    public const SLOTS = [
        'Front',
        'Smile',
        'Profile',
        'Frontal (Intraoral)',
        'Right Buccal',
        'Left Buccal',
        'Upper Occlusal',
        'Lower Occlusal',
        'Panorex',
        'Lateral Ceph',
        'General Upload',
    ];

    private const ENDPOINT = 'https://openrouter.ai/api/v1/chat/completions';

    private const PROMPT_A_SYSTEM = <<<'TXT'
You are an orthodontic imaging classifier. You are shown ONE clinical image and must
decide which standard record slot it belongs to. Use these rules:
- Radiographs are flat, grayscale 2D X-rays (film look). 'Panorex' = wide panoramic
  of both jaws; 'Lateral Ceph' = side-view of the skull. BUT a 3D reconstruction / CBCT
  volume render (a solid, sculpted 3D model of the jaw or skull, usually tan/brown on a
  black background, sometimes with an R or L orientation marker) is NOT a Panorex or
  Ceph -> classify it as 'General Upload'. A digital intraoral-scan / STL render (smooth
  CGI teeth and gums, no bone) is also -> 'General Upload'.
- Extraoral photos show a whole face (no cheek retractors). Among frontal faces:
  if the person is SMILING with teeth visible -> 'Smile'; if lips are together /
  relaxed with teeth NOT showing -> 'Front'. A side view of the face -> 'Profile'.
- Intraoral photos show teeth up close, usually with black cheek retractors.
  * Occlusal views look straight into ONE dental arch (the biting surfaces of the
    molars form a U/horseshoe). Decide upper vs lower by the SOFT TISSUE inside the
    arch, NOT by the photo's orientation:
      - 'Upper Occlusal': the roof of the mouth (hard PALATE) fills the centre - a firm
        pale vault with WAVY horizontal ridges (rugae) just behind the front teeth and a
        midline seam. No tongue.
      - 'Lower Occlusal': the TONGUE / floor of the mouth fills the centre - either the
        tongue's bumpy top (soft, papillae, midline groove) or, when the tongue is down,
        the wet floor of the mouth with a central vertical fold (frenulum) and saliva.
        Soft and wet, never the ridged pale palate.
  * For a teeth-together bite view, SCAN the row of teeth from the LEFT edge of the image
    across to the RIGHT edge, and note the ORDER in which the FRONT teeth (flat central
    INCISORS + pointed CANINE) and the back MOLARS appear. Use only positions in the
    image; ignore the patient's anatomical side and any mirroring:
      - FRONT teeth come FIRST (on the left) and the teeth become MOLARS toward the right
        -> 'Left Buccal'.
      - MOLARS come first (on the left) and the FRONT teeth appear LATER (toward the
        right) -> 'Right Buccal'.
      - The FRONT teeth sit in the MIDDLE with the arch curving away SYMMETRICALLY on BOTH
        sides (you see left teeth and right teeth roughly equally, neither side's molars
        dominating) -> 'Frontal (Intraoral)'.
    A Buccal view shows mostly ONE side (front teeth at one end, molars at the other). A
    Frontal view is a straight-on, symmetric both-sides view. When a full side of molars
    is visible trailing off to one edge, it is a Buccal, NOT Frontal.
TXT;

    private const PROMPT_A_USER = <<<'TXT'
Classify this image into EXACTLY ONE of these slots:
- Front
- Smile
- Profile
- Frontal (Intraoral)
- Right Buccal
- Left Buccal
- Upper Occlusal
- Lower Occlusal
- Panorex
- Lateral Ceph
- General Upload

Respond with ONLY a JSON object, no prose, no code fence:
{"slot": "<one slot exactly as written above>", "confidence": <0.0-1.0>, "reason": "<max 10 words>"}
TXT;

    // ONE call per intraoral bite view that answers BOTH hard questions at once, so the
    // whole of Pass 2 fits in a single parallel batch:
    //  (a) Frontal vs Buccal - by symmetry (both sides visible) vs one-sided layout.
    //  (b) If Buccal, the horizontal FRAME position of the front teeth vs the back molars.
    // We never ask the model for "left vs right buccal" (a mirror/anatomy call it gets
    // confidently wrong); PHP derives the side from the positions:
    //   front teeth LEFT of the molars -> Left Buccal; RIGHT of the molars -> Right Buccal.
    private const PROMPT_BITEVIEW_POS = <<<'TXT'
This is an intraoral bite photo (teeth together, taken with a cheek retractor). Answer about
THIS image only, judging PURELY by the layout of the teeth in the frame - ignore the
patient's anatomy, the camera direction, and any mirroring.

1) "type":
   - "frontal" = a straight-on view: the front teeth are centred and the arch curves away
     SYMMETRICALLY, so the left side and the right side are visible roughly equally (neither
     side's molars dominate).
   - "buccal" = a SIDE view: only ONE side is shown - the front teeth (flat central incisors
     + pointed canine) sit toward ONE end and a run of MOLARS trails off toward the OTHER end.

2) If "buccal", report the horizontal position from 0 to 100 (0 = far LEFT edge, 100 = far
   RIGHT edge) of:
   - "front_x": the FRONT teeth (central incisors + pointed canine)
   - "back_x": the widest BACK molar visible
   If "frontal", set both front_x and back_x to 50.

Return ONLY JSON, no prose:
{"type": "frontal" or "buccal", "front_x": <0-100>, "back_x": <0-100>, "why": "<max 12 words>"}
TXT;

    private const PROMPT_C = <<<'TXT'
These are the TWO occlusal (biting-surface) intraoral photos of one orthodontic patient,
IMAGE 1 then IMAGE 2. Each looks straight into ONE dental arch (the teeth form a
U/horseshoe). Usually one is the UPPER arch and one is the LOWER arch (rarely both the
same). Decide each image by the TISSUE INSIDE the horseshoe of teeth:

UPPER arch = "Upper Occlusal": the roof of the mouth / hard PALATE fills the centre.
Tell-tale sign: WAVY horizontal ridges (palatal rugae) just behind the front teeth, on a
firm, pale, dome-shaped vault with a midline seam. There is NO tongue.

LOWER arch = "Lower Occlusal": the TONGUE and floor of the mouth fill the centre.
Tell-tale sign: either the tongue's bumpy top surface (soft, covered in tiny papillae,
with a midline groove) OR - when the tongue is pushed down - the wet FLOOR of the mouth
beneath it, a soft recessed area with a central vertical fold (frenulum) and pooled
saliva. It is soft and wet, never the ridged pale palate.

Work step by step: for each image, first name what fills the centre (palatal rugae/vault
vs tongue/floor-of-mouth), then label it. Return ONLY JSON, no prose:
{"image_1": "Upper Occlusal" or "Lower Occlusal",
 "image_2": "Upper Occlusal" or "Lower Occlusal",
 "why": "centre of image1 = <rugae|tongue/floor>, image2 = <rugae|tongue/floor>"}
TXT;

    private string $key;
    private string $model;
    private string $fallbackModel;

    public function __construct()
    {
        $this->key = (string) config('services.openrouter.key');
        $this->model = (string) config('services.openrouter.model', 'google/gemini-2.5-flash-lite');
        $this->fallbackModel = (string) config('services.openrouter.fallback_model', 'google/gemini-2.5-flash');
    }

    /**
     * Classify a batch of images.
     *
     * @param  array<int, array{index:int, data_uri:string}>  $images
     * @return array<int, array{index:int, slot:string, confidence:float, reason:string}>
     */
    public function classify(array $images): array
    {
        if (empty($images)) {
            return [];
        }

        $results = $this->classifyPassOne($images);

        // Pass 2 - fix the two hard slot families.
        //
        // Buccal Left/Right: the model cannot reliably say "left vs right buccal" (a
        // mirror/anatomy judgement it gets confidently wrong, and references make it worse
        // because it misreads their geometry too). Instead the whole of Pass 2 runs as ONE
        // parallel batch: a merged Frontal-vs-Buccal + front/back position read per bite
        // view, plus the occlusal upper/lower pair - then PHP derives every label. This keeps
        // the round-trips to two total (Pass 1, then Pass 2) instead of a sequential chain.
        $results = $this->runPassTwo($images, $results);

        // Return in the same order as the input.
        return array_values($results);
    }

    /**
     * Pass 1 - classify every image in parallel, keyed by its index.
     *
     * @param  array<int, array{index:int, data_uri:string}>  $images
     * @return array<int, array{index:int, slot:string, confidence:float, reason:string}>  keyed by index
     */
    private function classifyPassOne(array $images): array
    {
        $responses = Http::pool(fn ($pool) => array_map(
            fn ($img) => $this->buildPassOneRequest($pool->as((string) $img['index']), $img['data_uri']),
            $images
        ));

        $results = [];
        foreach ($images as $img) {
            $idx = $img['index'];
            $resp = $responses[(string) $idx] ?? null;
            $parsed = $this->parsePassOne($resp);

            if ($parsed === null) {
                // Retry once with the fallback model, synchronously.
                $parsed = $this->retryPassOne($img['data_uri']);
            }

            $results[$idx] = [
                'index' => $idx,
                'slot' => $parsed['slot'] ?? 'General Upload',
                'confidence' => $parsed['confidence'] ?? 0.0,
                'reason' => $parsed['reason'] ?? 'could not classify',
            ];
        }

        return $results;
    }

    private function buildPassOneRequest($request, string $dataUri)
    {
        return $request
            ->withToken($this->key)
            // Force HTTP/1.1: the local static PHP build's curl has a broken HTTP/3
            // (ngtcp2) that aborts on alt-svc upgrade. Harmless on production PHP.
            ->withOptions(['version' => 1.1])
            ->timeout(90)
            ->post(self::ENDPOINT, [
                'model' => $this->model,
                'temperature' => 0,
                'messages' => [
                    ['role' => 'system', 'content' => self::PROMPT_A_SYSTEM],
                    ['role' => 'user', 'content' => [
                        ['type' => 'text', 'text' => self::PROMPT_A_USER],
                        ['type' => 'image_url', 'image_url' => ['url' => $dataUri]],
                    ]],
                ],
            ]);
    }

    /**
     * @return array{slot:string, confidence:float, reason:string}|null
     */
    private function parsePassOne($response): ?array
    {
        try {
            if (! $response || ! method_exists($response, 'successful') || ! $response->successful()) {
                return null;
            }
            $content = data_get($response->json(), 'choices.0.message.content');
            $json = $this->extractJson((string) $content);
            if ($json === null || ! isset($json['slot'])) {
                return null;
            }
            $slot = $this->normalizeSlot((string) $json['slot']);
            if ($slot === null) {
                return null;
            }

            return [
                'slot' => $slot,
                'confidence' => (float) ($json['confidence'] ?? 0.0),
                'reason' => (string) ($json['reason'] ?? ''),
            ];
        } catch (Throwable $e) {
            Log::warning('ImageClassifier parsePassOne failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * @return array{slot:string, confidence:float, reason:string}|null
     */
    private function retryPassOne(string $dataUri): ?array
    {
        try {
            $resp = Http::withToken($this->key)
                ->withOptions(['version' => 1.1])
                ->timeout(90)
                ->post(self::ENDPOINT, [
                    'model' => $this->fallbackModel,
                    'temperature' => 0,
                    'messages' => [
                        ['role' => 'system', 'content' => self::PROMPT_A_SYSTEM],
                        ['role' => 'user', 'content' => [
                            ['type' => 'text', 'text' => self::PROMPT_A_USER],
                            ['type' => 'image_url', 'image_url' => ['url' => $dataUri]],
                        ]],
                    ],
                ]);

            return $this->parsePassOne($resp);
        } catch (Throwable $e) {
            Log::warning('ImageClassifier retryPassOne failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Pass 2, as ONE parallel batch. For each intraoral bite view (Frontal / Buccal) we send
     * a single merged call that returns Frontal-vs-Buccal AND, for buccals, the front/back
     * horizontal positions; and - when there are exactly two occlusals - one pair call for
     * upper/lower. All of these fire together in a single Http::pool, then PHP derives the
     * labels. This keeps Pass 2 to one network round-trip instead of a sequential chain.
     *
     * @param  array<int, array{index:int, data_uri:string}>  $images
     * @param  array<int, array{index:int, slot:string, confidence:float, reason:string}>  $results  keyed by index
     * @return array<int, array{index:int, slot:string, confidence:float, reason:string}>  keyed by index
     */
    private function runPassTwo(array $images, array $results): array
    {
        $byIndex = [];
        foreach ($images as $img) {
            $byIndex[$img['index']] = $img['data_uri'];
        }

        $biteIdx = []; // Frontal (Intraoral) / Left Buccal / Right Buccal
        $occIdx = [];  // Upper/Lower Occlusal
        foreach ($results as $idx => $r) {
            if (str_contains($r['slot'], 'Buccal') || $r['slot'] === 'Frontal (Intraoral)') {
                $biteIdx[] = $idx;
            } elseif (str_contains($r['slot'], 'Occlusal')) {
                $occIdx[] = $idx;
            }
        }

        if (empty($biteIdx) && count($occIdx) !== 2) {
            return $results;
        }

        // One pool: a merged bite-view call per bite image + the occlusal pair call.
        $responses = Http::pool(function ($pool) use ($biteIdx, $occIdx, $byIndex) {
            $reqs = [];
            foreach ($biteIdx as $idx) {
                $reqs[] = $pool->as('bite_'.$idx)
                    ->withToken($this->key)
                    ->withOptions(['version' => 1.1])
                    ->timeout(90)
                    ->post(self::ENDPOINT, [
                        'model' => $this->model,
                        'temperature' => 0,
                        'messages' => [['role' => 'user', 'content' => [
                            ['type' => 'text', 'text' => self::PROMPT_BITEVIEW_POS],
                            ['type' => 'image_url', 'image_url' => ['url' => $byIndex[$idx]]],
                        ]]],
                    ]);
            }
            if (count($occIdx) === 2) {
                $reqs[] = $pool->as('occ')
                    ->withToken($this->key)
                    ->withOptions(['version' => 1.1])
                    ->timeout(90)
                    ->post(self::ENDPOINT, [
                        'model' => $this->fallbackModel,
                        'temperature' => 0,
                        'messages' => [['role' => 'user', 'content' => [
                            ['type' => 'text', 'text' => self::PROMPT_C],
                            ['type' => 'image_url', 'image_url' => ['url' => $byIndex[$occIdx[0]]]],
                            ['type' => 'image_url', 'image_url' => ['url' => $byIndex[$occIdx[1]]]],
                        ]]],
                    ]);
            }

            return $reqs;
        });

        // Bite views: frontal stays frontal; buccals collect positions, then reconcile.
        $pos = []; // buccal idx => ['front','back','sep','why']
        foreach ($biteIdx as $idx) {
            $b = $this->parseBiteView($responses['bite_'.$idx] ?? null);
            if ($b === null) {
                continue; // keep Pass 1's guess
            }
            if ($b['type'] === 'frontal') {
                $results[$idx]['slot'] = 'Frontal (Intraoral)';
                $results[$idx]['confidence'] = 0.9;
                $results[$idx]['reason'] = 'bite-view: frontal (symmetric)';
            } else {
                $pos[$idx] = ['front' => $b['front'], 'back' => $b['back'], 'sep' => abs($b['front'] - $b['back']), 'why' => $b['why']];
            }
        }
        $results = $this->assignBuccalSides($results, $pos);

        // Occlusal upper/lower pair.
        if (count($occIdx) === 2) {
            $pair = $this->parseOcclusalPair($responses['occ'] ?? null);
            if ($pair !== null) {
                [$o1, $o2] = $occIdx;
                $results[$o1]['slot'] = $pair['image_1'];
                $results[$o2]['slot'] = $pair['image_2'];
                $results[$o1]['confidence'] = max($results[$o1]['confidence'], 0.9);
                $results[$o2]['confidence'] = max($results[$o2]['confidence'], 0.9);
                $results[$o1]['reason'] = 'occlusal pair: '.$pair['why'];
                $results[$o2]['reason'] = 'occlusal pair: '.$pair['why'];
            }
        }

        return $results;
    }

    /**
     * Turn parsed buccal positions into Left/Right slots. Rule: front teeth left of the
     * molars => Left Buccal; right of the molars => Right Buccal. For the clean two-buccal
     * case they must be opposite, so if both read the same side, force opposite by relative
     * front position (and lower confidence so the pair gets a human glance).
     *
     * @param  array<int, array{index:int, slot:string, confidence:float, reason:string}>  $results  keyed by index
     * @param  array<int, array{front:float, back:float, sep:float, why:string}>  $pos  keyed by buccal index
     * @return array<int, array{index:int, slot:string, confidence:float, reason:string}>  keyed by index
     */
    private function assignBuccalSides(array $results, array $pos): array
    {
        if (empty($pos)) {
            return $results;
        }
        $sideOf = fn (array $p) => $p['front'] < $p['back'] ? 'Left Buccal' : 'Right Buccal';
        $apply = function (int $idx, string $side, float $conf, string $why) use (&$results) {
            $results[$idx]['slot'] = $side;
            $results[$idx]['confidence'] = $conf;
            $results[$idx]['reason'] = 'buccal position: '.$why;
        };
        $idxs = array_keys($pos);

        if (count($idxs) === 2) {
            [$a, $b] = $idxs;
            $pa = $pos[$a];
            $pb = $pos[$b];
            $sa = $sideOf($pa);
            $sb = $sideOf($pb);
            if ($sa !== $sb) {
                $apply($a, $sa, $pa['sep'] >= 15 ? 0.9 : 0.6, $pa['why']);
                $apply($b, $sb, $pb['sep'] >= 15 ? 0.9 : 0.6, $pb['why']);
            } elseif ($pa['front'] <= $pb['front']) {
                $apply($a, 'Left Buccal', 0.55, 'relative: front teeth further left');
                $apply($b, 'Right Buccal', 0.55, 'relative: front teeth further right');
            } else {
                $apply($a, 'Right Buccal', 0.55, 'relative: front teeth further right');
                $apply($b, 'Left Buccal', 0.55, 'relative: front teeth further left');
            }

            return $results;
        }

        foreach ($pos as $idx => $p) {
            $apply($idx, $sideOf($p), $p['sep'] >= 15 ? 0.9 : 0.6, $p['why']);
        }

        return $results;
    }

    /**
     * Parse a PROMPT_BITEVIEW_POS reply: Frontal-vs-Buccal plus (for buccals) front/back
     * frame positions.
     *
     * @return array{type:string, front:float, back:float, why:string}|null
     */
    private function parseBiteView($response): ?array
    {
        try {
            if (! $response || ! method_exists($response, 'successful') || ! $response->successful()) {
                return null;
            }
            $json = $this->extractJson((string) data_get($response->json(), 'choices.0.message.content'));
            if ($json === null || ! isset($json['type'])) {
                return null;
            }
            $type = str_contains(strtolower((string) $json['type']), 'frontal') ? 'frontal' : 'buccal';

            return [
                'type' => $type,
                'front' => (float) ($json['front_x'] ?? 50),
                'back' => (float) ($json['back_x'] ?? 50),
                'why' => (string) ($json['why'] ?? ''),
            ];
        } catch (Throwable $e) {
            Log::warning('ImageClassifier parseBiteView failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Parse a PROMPT_C occlusal-pair reply into the two upper/lower slots.
     *
     * @return array{image_1:string, image_2:string, why:string}|null
     */
    private function parseOcclusalPair($response): ?array
    {
        try {
            if (! $response || ! method_exists($response, 'successful') || ! $response->successful()) {
                return null;
            }
            $json = $this->extractJson((string) data_get($response->json(), 'choices.0.message.content'));
            $s1 = $this->normalizeSlot((string) ($json['image_1'] ?? ''));
            $s2 = $this->normalizeSlot((string) ($json['image_2'] ?? ''));
            $valid = ['Upper Occlusal', 'Lower Occlusal'];
            if (! in_array($s1, $valid, true) || ! in_array($s2, $valid, true)) {
                return null;
            }

            return ['image_1' => $s1, 'image_2' => $s2, 'why' => (string) ($json['why'] ?? '')];
        } catch (Throwable $e) {
            Log::warning('ImageClassifier parseOcclusalPair failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Pull the first {...} JSON object out of a model reply, tolerating code
     * fences or stray prose.
     *
     * @return array<string, mixed>|null
     */
    private function extractJson(string $text): ?array
    {
        $start = strpos($text, '{');
        $end = strrpos($text, '}');
        if ($start === false || $end === false || $end <= $start) {
            return null;
        }
        $decoded = json_decode(substr($text, $start, $end - $start + 1), true);

        return is_array($decoded) ? $decoded : null;
    }

    /**
     * Map a model-returned slot string onto one of the canonical SLOTS
     * (case-insensitive, trimmed). Returns null if it matches none.
     */
    private function normalizeSlot(string $slot): ?string
    {
        $slot = trim($slot);
        foreach (self::SLOTS as $canonical) {
            if (strcasecmp($slot, $canonical) === 0) {
                return $canonical;
            }
        }

        return null;
    }
}
