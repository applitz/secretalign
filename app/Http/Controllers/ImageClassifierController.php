<?php

namespace App\Http\Controllers;

use App\Http\Services\ImageClassifierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Receives a batch of client-resized dental images and returns the slot each
 * one belongs to (Front, Smile, ... Panorex, Lateral Ceph, General Upload),
 * classified by the vision LLM via OpenRouter.
 *
 * Used by the bulk "auto-segregation" uploader on the Images / X-Rays wizard step.
 */
class ImageClassifierController extends Controller
{
    /** Max images accepted in one batch (a full case is ~11-13 photos). */
    private const MAX_IMAGES = 15;

    public function classify(Request $request, $patient_id, ImageClassifierService $classifier): JsonResponse
    {
        if (empty(config('services.openrouter.key'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Image classification is not configured (missing OpenRouter key).',
            ], 503);
        }

        $validator = Validator::make($request->all(), [
            'images' => 'required|array|min:1|max:'.self::MAX_IMAGES,
            'images.*.index' => 'required|integer',
            'images.*.data_uri' => ['required', 'string', 'regex:/^data:image\/[a-zA-Z0-9.+-]+;base64,/'],
        ], [
            'images.max' => 'You can auto-classify at most '.self::MAX_IMAGES.' images at once.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $images = array_map(fn ($img) => [
            'index' => (int) $img['index'],
            'data_uri' => (string) $img['data_uri'],
        ], $request->input('images'));

        $results = $classifier->classify($images);

        return response()->json([
            'status' => 'success',
            'min_confidence' => (float) config('services.openrouter.min_confidence', 0.6),
            'results' => $results,
        ]);
    }
}
