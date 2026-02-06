<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Nette\Utils\Json;

    function getDynamicEncryptionToken($domainName) {
        $response = Http::withHeaders([
                'X-Auth-AppID' => config('shining3d.shining3d_app_id'),
            ])->get($domainName . '/sdk/auth/dynamicEncodeToken')->json();

        return $response;
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

        return Json::encode($response);
    }


    function exchangeCodeForToken(string $code, string $domainName)
    {
        $response = Http::withHeaders([
            'X-Auth-AppID' => config('shining3d.shining3d_app_id'),
            'Content-Type' => 'application/json',
        ])->post($domainName . '/u/sdk/oauth2/token', [
            'grantType'   => 'authorizationCode',
            'responseType' => 'token',
            'codeVerifier' => 'PLAIN',
            'code'         => $code,
            'redirectUri'  => 'https://secretalign-user.com/patient/create',
        ]);

        if (!$response->successful()) {
            throw new \RuntimeException(
                'Token exchange failed: ' . $response->body()
            );
        }

        return $response->json();
    }


    function getOrderList($baseUrl, $authToken, $doctorID, $orgcode, $start_date, $end_date)
    {
        $response = Http::withHeaders([
            'X-Auth-Token' => $authToken,
            'X-Auth-AppKey' => config('shining3d.shining3d_app_key'),
            'X-Auth-AppID' => config('shining3d.shining3d_app_id'),
        ])->get($baseUrl . '/sdk/dental/order/list', [
            'orgType' => 'hospital',
            'doctorID' => $doctorID,
            'orgCode' => $orgcode,
            'page' => 1,
            'pageSize' => 10,
            'startOn' => Carbon::parse($start_date)->format('Y-m-d'),
            'endOn' => Carbon::parse($end_date)->format('Y-m-d'),
        ]);
        return $response->json();
    }
?>
