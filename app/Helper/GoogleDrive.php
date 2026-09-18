<?php
use Illuminate\Support\Facades\Http;
use Google\Client;
use Google\Service\Drive;

function isGoogleDriveLink($url)
{
    return preg_match('/^https?:\/\/drive\.google\.com\/(file|drive|open)\//', $url);
}

function extractFolderId(string $url): ?string
{
    if (preg_match('#/folders/([^/?]+)#', $url, $m)) {
        return $m[1];
    }
    return null;
}

function checkTreatmentLinkIsPublicOrNot($url){

    $folderId = extractFolderId($url);
    if (!$folderId) {
        return false; // Invalid URL format
    }

    // Construct the Google Drive URL to check
   $url = "https://drive.google.com/embeddedfolderview?id={$folderId}#grid";
    try {
        $response = Http::get($url);
        if (!$response->successful()) {
            return false;
        }

        $body = $response->body();
        return !(
            str_contains($body, 'You need access') ||
            str_contains($body, 'request access') ||
            str_contains($body, 'Sign in')
        );
    } catch (\Exception $e) {
        return false;
    }
    return false;
}

function listPublicDriveFiles($url)
{
    if (!isGoogleDriveLink($url)) {
        return [];
    } elseif (!checkTreatmentLinkIsPublicOrNot($url)) {
        return [];
    } elseif (!extractFolderId($url)) {
        return [];
    } else {
        $folderId = extractFolderId($url);

        $client = new Google\Client();
        $client->setApplicationName('SECRETALIGN');
        $client->setDeveloperKey('AIzaSyBmRLqMpqVZUtrPnbyJZ6iakwLeFGliEK8');
        $service = new Google\Service\Drive($client);
        $pageToken = null;
        $response = $service->files->listFiles([
            'q' => "'$folderId' in parents and trashed = false",
            'orderBy' => 'name',
            'pageSize' => 1000,
            'fields' => 'files(id, name, mimeType, webContentLink)',
            'pageToken' => $pageToken,
        ]);

        $files = $response->getFiles();

        // ✅ Filter STL and PTS files
        return array_filter($files, function ($file) {
            $ext = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
            return in_array($ext, ['stl', 'pts']);
        });
    }
}


function listPublicDriveFilesOld($url)
{
    if (!isGoogleDriveLink($url)) {
        return [];
    } elseif (!checkTreatmentLinkIsPublicOrNot($url)) {
        return [];
    } elseif (!extractFolderId($url)) {
        return [];
    } else {
        $folderId = extractFolderId($url);
        // Initialize Google client
        $client = new Client();
        $client->setApplicationName('SECRETALIGN');
        $client->setDeveloperKey('AIzaSyBmRLqMpqVZUtrPnbyJZ6iakwLeFGliEK8'); // Use API Key (no OAuth needed for public)
        $service = new Drive($client);
        // Query to list all files in the folder
        $response = $service->files->listFiles([
            'q' => "'$folderId' in parents and trashed = false",
            'orderBy' => 'name',
            'fields' => 'files(id, name, mimeType, webViewLink, webContentLink)',
        ]);
        $allFiles = $response->getFiles();

        // Filter only STL files (case-insensitive check)
        $stlFiles = array_filter($allFiles, function ($file) {
            return str_ends_with(strtolower($file->name), '.stl');
        });

        return $stlFiles;
    }
}

/**
 * Pull a Drive file id out of a single-file share link, e.g.
 *   https://drive.google.com/file/d/<ID>/view?usp=sharing
 *   https://drive.google.com/open?id=<ID>
 *   https://drive.google.com/uc?id=<ID>&export=download
 */
function extractFileId(string $url): ?string
{
    if (preg_match('#/file/d/([^/?]+)#', $url, $m)) {
        return $m[1];
    }
    if (preg_match('#[?&]id=([^&]+)#', $url, $m)) {
        return $m[1];
    }
    return null;
}

/**
 * List image files inside a public Drive folder link (jpg/png/webp/gif/bmp,
 * or anything with an image/* mime). Mirrors listPublicDriveFiles() but for the
 * Images / X-Rays auto-segregation uploader. Returns Google\Service\Drive\DriveFile[].
 */
function listPublicDriveImages($url)
{
    if (!isGoogleDriveLink($url) || !checkTreatmentLinkIsPublicOrNot($url)) {
        return [];
    }
    $folderId = extractFolderId($url);
    if (!$folderId) {
        return [];
    }

    $client = new Google\Client();
    $client->setApplicationName('SECRETALIGN');
    $client->setDeveloperKey('AIzaSyBmRLqMpqVZUtrPnbyJZ6iakwLeFGliEK8');
    $service = new Google\Service\Drive($client);
    $response = $service->files->listFiles([
        'q' => "'$folderId' in parents and trashed = false",
        'orderBy' => 'name',
        'pageSize' => 1000,
        'fields' => 'files(id, name, mimeType)',
    ]);

    return array_values(array_filter($response->getFiles(), function ($file) {
        $ext = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
        $mime = strtolower((string) $file->mimeType);
        return in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'heic'])
            || str_starts_with($mime, 'image/');
    }));
}

/**
 * Download the raw bytes of a public Drive file by id, preferring the API
 * (alt=media, avoids the virus-scan interstitial) and falling back to the
 * public direct-download URL. Returns null on failure.
 */
function downloadPublicDriveFileBytes(string $fileId): ?string
{
    try {
        $client = new Google\Client();
        $client->setApplicationName('SECRETALIGN');
        $client->setDeveloperKey('AIzaSyBmRLqMpqVZUtrPnbyJZ6iakwLeFGliEK8');
        $service = new Google\Service\Drive($client);
        $response = $service->files->get($fileId, ['alt' => 'media']);
        $bytes = (string) $response->getBody();
        if ($bytes !== '') {
            return $bytes;
        }
    } catch (\Throwable $e) {
        // fall through to the public URL
    }

    try {
        $ctx = stream_context_create(['http' => ['timeout' => 60], 'https' => ['timeout' => 60]]);
        $bytes = @file_get_contents("https://drive.google.com/uc?export=download&id={$fileId}", false, $ctx);
        return ($bytes !== false && $bytes !== '') ? $bytes : null;
    } catch (\Throwable $e) {
        return null;
    }
}

function extractStepIdentifier($fileName)
{
    if (preg_match('/^([LU])_Step[_\-](\d{1,2})/', $fileName, $matches)) {
        $prefix = $matches[1]; // 'L' or 'U'
        $stepNumber = (int)$matches[2] + 1; // Convert to int and add 1 to make 00 => 1, 01 => 2, etc.
        return $prefix . $stepNumber;
    }

    return null; // if pattern doesn't match
}

function extractStepPartsOld($fileName)
{
    if (preg_match('/^([LU])_Step[_\-](\d{1,2})/', $fileName, $matches)) {
        return [
            'direction' => $matches[1], // 'L' or 'U'
            'step' => (int) $matches[2], // Convert 00 => 1
        ];
    }
    return null;
}

function extractStepParts($fileName)
{
    // Match patterns like:
    // U_Step_00.stl, L_Step_01.stl, U_Step_RET.stl, L_Step_00_Attachment.pts
    if (preg_match('/^([LU])_Step[_\-]([A-Za-z0-9]+)(?:[_\-][A-Za-z0-9]+)?/i', $fileName, $matches)) {
        return [
            'direction' => strtoupper($matches[1]), // U or L
            'step' => $matches[2], // can be number, RET, Attachment, etc.
        ];
    }
    return null;
}

?>
