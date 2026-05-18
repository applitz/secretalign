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
