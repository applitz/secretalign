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

    // Buccal Left/Right, decided WITHOUT ever asking the model for the clinical label.
    // The model is unreliable at "left vs right buccal" (a mirror/anatomy judgement), but
    // reliable at reading WHERE things sit in the frame. So we ask only for the horizontal
    // pixel position of two landmarks and derive the side in PHP:
    //   front teeth LEFT of the molars  -> Left Buccal
    //   front teeth RIGHT of the molars -> Right Buccal
    private const PROMPT_BUCCAL_POS = <<<'TXT'
This is a single side-view (buccal) intraoral photo of teeth in bite, taken with a cheek retractor.

Report where two landmarks sit HORIZONTALLY in THIS image, as a number from 0 to 100:
0 = the far LEFT edge of the image, 100 = the far RIGHT edge.
- "front_x": the FRONT teeth = the flat, square central incisors and the pointed CANINE next to them (the middle/front of the smile).
- "back_x": the widest BACK molar visible (the big chewing teeth at the rear of the mouth).

Judge ONLY by where each landmark appears in this picture. Do NOT consider the patient's
anatomical left/right, the camera direction, or any mirroring. Just read pixel positions.

Return ONLY JSON, no prose:
{"front_x": <0-100>, "back_x": <0-100>, "why": "<max 12 words>"}
TXT;

    // Used to decide Frontal vs Buccal for one bite view against two labelled references
    // (left/right is decided separately by the reliable pair comparison).
    private const PROMPT_BITEVIEW = <<<'TXT'
The FIRST image is a CONFIRMED "Frontal (Intraoral)" example: a straight-on view where
the front teeth are centred and BOTH the left and right sides of the arch are visible
roughly symmetrically.
The SECOND image is a CONFIRMED BUCCAL (side) example: only ONE side is shown - the front
teeth sit toward one edge and a full run of molars trails off toward the other edge.

IMAGE 3 is the photo to classify. Is IMAGE 3 a FRONTAL view (symmetric, both sides) or a
BUCCAL side view (one side, molars trailing to an edge)? Judge only by the layout of the
teeth in the frame.

Return ONLY JSON, no prose:
{"type": "Frontal" or "Buccal", "confidence": <0.0-1.0>, "why": "max 15 words"}
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
        // because it misreads their geometry too). Instead we ask ONLY for the horizontal
        // position of the front teeth vs the back molars in each image, and derive the side
        // deterministically in PHP. If bite-view references exist, we still use them first
        // to fix the (different, non-mirror) Frontal-vs-Buccal confusion.
        $biteRefs = $this->loadBiteViewReferences();
        if ($biteRefs) {
            $results = $this->refineBiteViews($images, $results, $biteRefs);
        }
        $results = $this->resolveBuccalSides($images, $results);

        // Occlusal upper/lower is a soft-tissue (palate vs tongue) judgement, still reliable
        // as a pair comparison.
        $results = $this->resolvePair($images, $results, 'Occlusal', self::PROMPT_C, ['Upper Occlusal', 'Lower Occlusal'], $this->fallbackModel);

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
     * Pass 2 - if exactly two images share a hard slot family (Buccal or Occlusal),
     * compare them as a pair to reliably assign the two opposite sides.
     *
     * @param  array<int, array{index:int, data_uri:string}>  $images
     * @param  array<int, array{index:int, slot:string, confidence:float, reason:string}>  $results  keyed by index
     * @param  string  $needle       substring identifying the family, e.g. 'Buccal' or 'Occlusal'
     * @param  string  $prompt       the pair-comparison prompt
     * @param  array<int, string>  $validSlots  the two acceptable slot names for this family
     * @return array<int, array{index:int, slot:string, confidence:float, reason:string}>  keyed by index
     */
    private function resolvePair(array $images, array $results, string $needle, string $prompt, array $validSlots, ?string $model = null, array $refs = []): array
    {
        $matchIdx = [];
        foreach ($results as $idx => $r) {
            if (str_contains($r['slot'], $needle)) {
                $matchIdx[] = $idx;
            }
        }

        if (count($matchIdx) !== 2) {
            return $results; // only the clean 2-image case is reliable
        }

        $byIndex = [];
        foreach ($images as $img) {
            $byIndex[$img['index']] = $img['data_uri'];
        }

        [$i1, $i2] = $matchIdx;
        $pair = $this->classifyPair($byIndex[$i1], $byIndex[$i2], $prompt, $validSlots, $model ?? $this->model, $refs);

        if ($pair !== null) {
            $label = strtolower($needle).' pair';
            $results[$i1]['slot'] = $pair['image_1'];
            $results[$i2]['slot'] = $pair['image_2'];
            $results[$i1]['reason'] = $label.': '.$pair['why'];
            $results[$i2]['reason'] = $label.': '.$pair['why'];
            // Pair comparison is reliable; lift confidence so it auto-places.
            $results[$i1]['confidence'] = max($results[$i1]['confidence'], 0.9);
            $results[$i2]['confidence'] = max($results[$i2]['confidence'], 0.9);
        }

        return $results;
    }

    /**
     * @param  array<int, string>  $validSlots
     * @return array{image_1:string, image_2:string, why:string}|null
     */
    private function classifyPair(string $dataUri1, string $dataUri2, string $prompt, array $validSlots, ?string $model = null, array $refs = []): ?array
    {
        try {
            // When labelled reference examples are supplied, put them FIRST (left ref,
            // then right ref) so the two patient images become the 3rd and 4th images.
            $content = [['type' => 'text', 'text' => $prompt]];
            if (! empty($refs['left']) && ! empty($refs['right'])) {
                $content[] = ['type' => 'image_url', 'image_url' => ['url' => $refs['left']]];
                $content[] = ['type' => 'image_url', 'image_url' => ['url' => $refs['right']]];
            }
            $content[] = ['type' => 'image_url', 'image_url' => ['url' => $dataUri1]];
            $content[] = ['type' => 'image_url', 'image_url' => ['url' => $dataUri2]];

            $resp = Http::withToken($this->key)
                ->withOptions(['version' => 1.1])
                ->timeout(90)
                ->post(self::ENDPOINT, [
                    'model' => $model ?? $this->model,
                    'temperature' => 0,
                    'messages' => [
                        ['role' => 'user', 'content' => $content],
                    ],
                ]);

            if (! $resp->successful()) {
                return null;
            }
            $json = $this->extractJson((string) data_get($resp->json(), 'choices.0.message.content'));
            $s1 = $this->normalizeSlot((string) ($json['image_1'] ?? ''));
            $s2 = $this->normalizeSlot((string) ($json['image_2'] ?? ''));
            if (! in_array($s1, $validSlots, true) || ! in_array($s2, $validSlots, true)) {
                return null;
            }

            return ['image_1' => $s1, 'image_2' => $s2, 'why' => (string) ($json['why'] ?? '')];
        } catch (Throwable $e) {
            Log::warning('ImageClassifier classifyPair failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Assign Left/Right to every buccal image by reading the FRONT-teeth vs BACK-molar
     * horizontal position in the frame (one parallel call per buccal image), never by
     * asking the model for the clinical side. Rule: front teeth left of the molars =>
     * Left Buccal; front teeth right of the molars => Right Buccal.
     *
     * @param  array<int, array{index:int, data_uri:string}>  $images
     * @param  array<int, array{index:int, slot:string, confidence:float, reason:string}>  $results  keyed by index
     * @return array<int, array{index:int, slot:string, confidence:float, reason:string}>  keyed by index
     */
    private function resolveBuccalSides(array $images, array $results): array
    {
        $buccalIdx = [];
        foreach ($results as $idx => $r) {
            if (str_contains($r['slot'], 'Buccal')) {
                $buccalIdx[] = $idx;
            }
        }
        if (empty($buccalIdx)) {
            return $results;
        }

        $byIndex = [];
        foreach ($images as $img) {
            $byIndex[$img['index']] = $img['data_uri'];
        }

        // One position read per buccal image, in parallel.
        $responses = Http::pool(fn ($pool) => array_map(fn ($idx) => $pool->as((string) $idx)
            ->withToken($this->key)
            ->withOptions(['version' => 1.1])
            ->timeout(90)
            ->post(self::ENDPOINT, [
                'model' => $this->model,
                'temperature' => 0,
                'messages' => [['role' => 'user', 'content' => [
                    ['type' => 'text', 'text' => self::PROMPT_BUCCAL_POS],
                    ['type' => 'image_url', 'image_url' => ['url' => $byIndex[$idx]]],
                ]]],
            ]), $buccalIdx));

        // Parse the two positions for each buccal image.
        $pos = []; // idx => ['front' => float, 'back' => float, 'sep' => float]
        foreach ($buccalIdx as $idx) {
            $p = $this->parseBuccalPosition($responses[(string) $idx] ?? null);
            if ($p !== null) {
                $pos[$idx] = $p;
            }
        }

        // Turn a parsed position into a side + confidence, and write it back.
        $apply = function (int $idx, string $side, float $conf, string $why) use (&$results) {
            $results[$idx]['slot'] = $side;
            $results[$idx]['confidence'] = $conf;
            $results[$idx]['reason'] = 'buccal position: '.$why;
        };
        $sideOf = fn (array $p) => $p['front'] < $p['back'] ? 'Left Buccal' : 'Right Buccal';

        // The common, reliable case: exactly two buccals. They must be opposite sides, so
        // reconcile if the position reads happen to agree (or one failed to parse).
        if (count($buccalIdx) === 2 && isset($pos[$buccalIdx[0]], $pos[$buccalIdx[1]])) {
            [$a, $b] = $buccalIdx;
            $pa = $pos[$a];
            $pb = $pos[$b];
            $sa = $sideOf($pa);
            $sb = $sideOf($pb);
            if ($sa !== $sb) {
                // Opposite as expected — trust each read.
                $apply($a, $sa, $pa['sep'] >= 15 ? 0.9 : 0.6, $pa['why']);
                $apply($b, $sb, $pb['sep'] >= 15 ? 0.9 : 0.6, $pb['why']);
            } else {
                // Both read the same side: force opposite using the RELATIVE front position
                // (front teeth further left => the Left Buccal). Lower confidence so the
                // pair is flagged for a quick human glance.
                if ($pa['front'] <= $pb['front']) {
                    $apply($a, 'Left Buccal', 0.55, 'relative: front teeth further left');
                    $apply($b, 'Right Buccal', 0.55, 'relative: front teeth further right');
                } else {
                    $apply($a, 'Right Buccal', 0.55, 'relative: front teeth further right');
                    $apply($b, 'Left Buccal', 0.55, 'relative: front teeth further left');
                }
            }

            return $results;
        }

        // Fallback: any other count (1, or 3+). Decide each image on its own read.
        foreach ($buccalIdx as $idx) {
            if (! isset($pos[$idx])) {
                continue; // keep whatever pass 1 said
            }
            $p = $pos[$idx];
            $apply($idx, $sideOf($p), $p['sep'] >= 15 ? 0.9 : 0.6, $p['why']);
        }

        return $results;
    }

    /**
     * Parse a PROMPT_BUCCAL_POS reply into front/back positions.
     *
     * @return array{front:float, back:float, sep:float, why:string}|null
     */
    private function parseBuccalPosition($response): ?array
    {
        try {
            if (! $response || ! method_exists($response, 'successful') || ! $response->successful()) {
                return null;
            }
            $json = $this->extractJson((string) data_get($response->json(), 'choices.0.message.content'));
            if ($json === null || ! isset($json['front_x']) || ! isset($json['back_x'])) {
                return null;
            }
            $front = (float) $json['front_x'];
            $back = (float) $json['back_x'];

            return [
                'front' => $front,
                'back' => $back,
                'sep' => abs($front - $back),
                'why' => (string) ($json['why'] ?? ''),
            ];
        } catch (Throwable $e) {
            Log::warning('ImageClassifier parseBuccalPosition failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Match every intraoral bite view (Frontal / Left Buccal / Right Buccal) against the
     * three labelled reference photos, one parallel call per candidate. This resolves the
     * Frontal-vs-Buccal confusion and the Left/Right flip together.
     *
     * @param  array<int, array{index:int, data_uri:string}>  $images
     * @param  array<int, array{index:int, slot:string, confidence:float, reason:string}>  $results  keyed by index
     * @param  array{frontal:string, left:string, right:string}  $refs
     * @return array<int, array{index:int, slot:string, confidence:float, reason:string}>  keyed by index
     */
    private function refineBiteViews(array $images, array $results, array $refs): array
    {
        $family = ['Frontal (Intraoral)', 'Left Buccal', 'Right Buccal'];
        $candidates = [];
        foreach ($results as $idx => $r) {
            if (in_array($r['slot'], $family, true)) {
                $candidates[] = $idx;
            }
        }
        if (empty($candidates)) {
            return $results;
        }

        $byIndex = [];
        foreach ($images as $img) {
            $byIndex[$img['index']] = $img['data_uri'];
        }

        // Per-image: decide Frontal vs Buccal against the frontal + one buccal reference.
        // (Left/Right is NOT decided here - per-image L/R is unreliable; the buccal PAIR
        // comparison that runs afterwards assigns the sides.)
        $responses = Http::pool(fn ($pool) => array_map(fn ($idx) => $pool->as((string) $idx)
            ->withToken($this->key)
            ->withOptions(['version' => 1.1])
            ->timeout(90)
            ->post(self::ENDPOINT, [
                'model' => $this->fallbackModel,
                'temperature' => 0,
                'messages' => [['role' => 'user', 'content' => [
                    ['type' => 'text', 'text' => self::PROMPT_BITEVIEW],
                    ['type' => 'image_url', 'image_url' => ['url' => $refs['frontal']]],
                    ['type' => 'image_url', 'image_url' => ['url' => $refs['left']]],
                    ['type' => 'image_url', 'image_url' => ['url' => $byIndex[$idx]]],
                ]]],
            ]), $candidates));

        foreach ($candidates as $idx) {
            $resp = $responses[(string) $idx] ?? null;
            try {
                if (! $resp || ! method_exists($resp, 'successful') || ! $resp->successful()) {
                    continue;
                }
                $json = $this->extractJson((string) data_get($resp->json(), 'choices.0.message.content'));
                $type = strtolower(trim((string) ($json['type'] ?? '')));
                if (str_contains($type, 'frontal')) {
                    $results[$idx]['slot'] = 'Frontal (Intraoral)';
                    $results[$idx]['confidence'] = max((float) ($json['confidence'] ?? 0), 0.9);
                    $results[$idx]['reason'] = 'bite-view: frontal';
                } elseif (str_contains($type, 'buccal') || str_contains($type, 'side')) {
                    // Mark as buccal (placeholder side); the pair pass assigns Left/Right.
                    $results[$idx]['slot'] = 'Left Buccal';
                    $results[$idx]['confidence'] = max((float) ($json['confidence'] ?? 0), 0.9);
                    $results[$idx]['reason'] = 'bite-view: buccal (side pending pair)';
                }
            } catch (Throwable $e) {
                Log::warning('ImageClassifier refineBiteViews failed: '.$e->getMessage());
            }
        }

        return $results;
    }

    /**
     * Load the three bite-view references (frontal + left/right buccal) if all exist.
     *
     * @return array{frontal:string, left:string, right:string}|array{}
     */
    private function loadBiteViewReferences(): array
    {
        $f = (string) config('services.openrouter.ref_frontal');
        $l = (string) config('services.openrouter.buccal_ref_left');
        $r = (string) config('services.openrouter.buccal_ref_right');
        if ($f === '' || $l === '' || $r === '' || ! is_file($f) || ! is_file($l) || ! is_file($r)) {
            return [];
        }
        $fu = $this->fileToDataUri($f);
        $lu = $this->fileToDataUri($l);
        $ru = $this->fileToDataUri($r);

        return ($fu && $lu && $ru) ? ['frontal' => $fu, 'left' => $lu, 'right' => $ru] : [];
    }

    /**
     * Read an image file and return it as a base64 data URI, resized to <=768px (GD)
     * to keep the request small. Falls back to the raw bytes if GD can't handle it.
     */
    private function fileToDataUri(string $path, int $max = 768): ?string
    {
        $info = @getimagesize($path);
        $mime = $info['mime'] ?? 'image/jpeg';

        if (function_exists('imagecreatetruecolor')) {
            $src = null;
            if ($mime === 'image/jpeg') {
                $src = @imagecreatefromjpeg($path);
            } elseif ($mime === 'image/png') {
                $src = @imagecreatefrompng($path);
            } elseif ($mime === 'image/webp') {
                $src = @imagecreatefromwebp($path);
            }
            if ($src) {
                $w = imagesx($src);
                $h = imagesy($src);
                $scale = min(1, $max / max($w, $h));
                $nw = max(1, (int) round($w * $scale));
                $nh = max(1, (int) round($h * $scale));
                $dst = imagecreatetruecolor($nw, $nh);
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
                ob_start();
                imagejpeg($dst, null, 80);
                $bytes = ob_get_clean();
                imagedestroy($src);
                imagedestroy($dst);

                return 'data:image/jpeg;base64,'.base64_encode((string) $bytes);
            }
        }

        $raw = @file_get_contents($path);

        return $raw === false ? null : 'data:'.$mime.';base64,'.base64_encode($raw);
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
