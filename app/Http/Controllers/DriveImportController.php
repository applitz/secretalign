<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Fetches images from a public Google Drive link (folder or single file),
 * resizes them server-side, and returns them as data URIs. The browser then
 * runs them through the SAME classify + placement pipeline used for
 * dropped/selected files (see images-xray.blade.php).
 *
 * Reuses the existing Drive helper (app/Helper/GoogleDrive.php) and its
 * developer key — no new credentials. The folder/file must be shared
 * "Anyone with the link".
 */
class DriveImportController extends Controller
{
    /** Longest edge (px) the returned images are downscaled to (matches the client). */
    private const MAX_EDGE = 768;

    /** Max images accepted from one link (a full case is ~11-13 photos). */
    private const MAX_IMAGES = 15;

    public function fetch(Request $request, $patient_id): JsonResponse
    {
        $link = trim((string) $request->input('link'));

        if ($link === '') {
            return $this->err('Please paste a Google Drive link.');
        }
        if (!isGoogleDriveLink($link)) {
            return $this->err('That does not look like a Google Drive link.');
        }

        $folderId = extractFolderId($link);
        $targets = []; // [ ['id' => ..., 'name' => ...], ... ]

        if ($folderId) {
            if (!checkTreatmentLinkIsPublicOrNot($link)) {
                return $this->err('This Drive folder is not shared publicly. Set it to "Anyone with the link".');
            }
            foreach (listPublicDriveImages($link) as $f) {
                $targets[] = ['id' => (string) $f['id'], 'name' => (string) $f['name']];
            }
            if (empty($targets)) {
                return $this->err('No images found in that Drive folder.');
            }
        } else {
            $fileId = extractFileId($link);
            if (!$fileId) {
                return $this->err('Could not read a folder or file id from that link.');
            }
            $targets[] = ['id' => $fileId, 'name' => 'drive-image'];
        }

        if (count($targets) > self::MAX_IMAGES) {
            return $this->err('That folder has '.count($targets).' images (max '.self::MAX_IMAGES.'). Please use a folder with '.self::MAX_IMAGES.' or fewer.');
        }

        $images = [];
        $skipped = [];
        foreach ($targets as $t) {
            $bytes = downloadPublicDriveFileBytes($t['id']);
            $uri = $bytes !== null ? $this->toResizedDataUri($bytes) : null;
            if ($uri === null) {
                $skipped[] = $t['name'];
                continue;
            }
            $images[] = ['name' => $t['name'], 'data_uri' => $uri];
        }

        if (empty($images)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not download or read any images from that link.',
                'skipped' => $skipped,
            ], 422);
        }

        return response()->json([
            'status' => 'success',
            'images' => $images,
            'skipped' => $skipped,
            'count' => count($images),
        ]);
    }

    private function err(string $message): JsonResponse
    {
        return response()->json(['status' => 'error', 'message' => $message], 422);
    }

    /** Downscale raw image bytes to a <=MAX_EDGE JPEG data URI via GD, or null if undecodable. */
    private function toResizedDataUri(string $bytes, int $max = self::MAX_EDGE): ?string
    {
        if (!function_exists('imagecreatefromstring')) {
            return null;
        }
        $img = @imagecreatefromstring($bytes);
        if (!$img) {
            return null;
        }
        $w = imagesx($img);
        $h = imagesy($img);
        if ($w < 1 || $h < 1) {
            imagedestroy($img);
            return null;
        }
        $scale = min(1, $max / max($w, $h));
        $nw = max(1, (int) round($w * $scale));
        $nh = max(1, (int) round($h * $scale));

        $dst = imagecreatetruecolor($nw, $nh);
        // Flatten any transparency onto white so JPEG output looks right.
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefill($dst, 0, 0, $white);
        imagecopyresampled($dst, $img, 0, 0, 0, 0, $nw, $nh, $w, $h);

        ob_start();
        imagejpeg($dst, null, 80);
        $out = ob_get_clean();
        imagedestroy($img);
        imagedestroy($dst);

        return ($out === false || $out === '') ? null : ('data:image/jpeg;base64,'.base64_encode($out));
    }
}
