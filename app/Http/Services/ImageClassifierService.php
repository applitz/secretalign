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
  * Teeth-in-bite views (front teeth touching, seen from the front or side) are told
    apart ONLY by where the FRONT teeth (flat central INCISORS + pointed CANINE) sit in
    the IMAGE frame. Ignore the patient's anatomical left/right and any mirroring - use
    only the position in the picture:
      - FRONT teeth near the CENTRE of the image, arch roughly symmetric -> 'Frontal (Intraoral)'.
      - FRONT teeth in the LEFT half of the image  -> 'Left Buccal'.
      - FRONT teeth in the RIGHT half of the image -> 'Right Buccal'.
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

    private const PROMPT_B = <<<'TXT'
These are the TWO lateral BUCCAL (side) intraoral photos of one orthodontic patient,
IMAGE 1 then IMAGE 2 (taken with cheek retractors).

Classify EACH image using ONLY the left/right POSITION of the front teeth WITHIN THE
PICTURE. Do NOT think about the patient's anatomical left or right. Do NOT think about
mirrors or camera direction. Use only where things are in the image frame.

For each image, do this:
Step 1 - Find the FRONT teeth: the flat, square CENTRAL INCISORS and the pointed CANINE
beside them (the middle/front of the smile). The wide, bumpy MOLARS are the BACK teeth.
Step 2 - Decide which HALF of the picture the FRONT teeth are in (left half or right half).
Step 3 - Label using this exact mapping (no exceptions, no flipping):
   * FRONT teeth in the LEFT half of the image  =>  "Left Buccal"
   * FRONT teeth in the RIGHT half of the image =>  "Right Buccal"

Ignore lips, cheeks, retractors and skin. Return ONLY JSON, no prose:
{"image_1": "Right Buccal" or "Left Buccal",
 "image_2": "Right Buccal" or "Left Buccal",
 "why": "front teeth in <left|right> half of image1, <left|right> half of image2"}
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

        // Pass 2 - pairwise disambiguation for the two hard "left/right, upper/lower"
        // slot families. Comparing the two side-by-side is far more reliable than
        // judging each alone (the model is otherwise confidently wrong on these).
        // Buccal L/R is the hardest call; use the stronger model for the pair comparison.
        $results = $this->resolvePair($images, $results, 'Buccal', self::PROMPT_B, ['Right Buccal', 'Left Buccal'], $this->fallbackModel);
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
    private function resolvePair(array $images, array $results, string $needle, string $prompt, array $validSlots, ?string $model = null): array
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
        $pair = $this->classifyPair($byIndex[$i1], $byIndex[$i2], $prompt, $validSlots, $model ?? $this->model);

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
    private function classifyPair(string $dataUri1, string $dataUri2, string $prompt, array $validSlots, ?string $model = null): ?array
    {
        try {
            $resp = Http::withToken($this->key)
                ->withOptions(['version' => 1.1])
                ->timeout(90)
                ->post(self::ENDPOINT, [
                    'model' => $model ?? $this->model,
                    'temperature' => 0,
                    'messages' => [
                        ['role' => 'user', 'content' => [
                            ['type' => 'text', 'text' => $prompt],
                            ['type' => 'image_url', 'image_url' => ['url' => $dataUri1]],
                            ['type' => 'image_url', 'image_url' => ['url' => $dataUri2]],
                        ]],
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
