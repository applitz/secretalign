<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;


function getDynamicEncryptionToken($domainName) {
    $response = Http::withHeaders([
            'X-Auth-AppID' => config('shining3d.shining3d_app_id'),
        ])->get($domainName . '/sdk/auth/dynamicEncodeToken')->json();

    return $response['result'];
}

function connect(string $domainName, $csrfToken): string
{
    $url = $domainName . '/sdk/auth/connect?publicKey=' . config('shining3d.shining3d_public_key');
    $body = json_encode(['publicKey' => config('shining3d.shining3d_public_key')]);


    $response = Http::withHeaders([
    'X-Auth-CSRF' => $csrfToken,
    'X-Auth-AppKey' => config('shining3d.shining3d_app_key'),
    'X-Auth-AppID' => config('shining3d.shining3d_app_id'),
    'Content-Type' => 'application/json',
    ])->withBody($body, 'application/json')->send('GET', $url)->json();


    if (($response['status'] ?? null) !== 'success') {
        throw new \RuntimeException('Failed to get auth token');
    }

    return $response['result'];
}


?>
