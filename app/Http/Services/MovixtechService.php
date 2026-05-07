<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PatientTreatmentPlan;
use App\Models\Patients;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class MovixtechService
{

 /**
     * Common API Request
     */
    public function movixRequest($method, $endpoint, $data = [])
    {
        $token = $this->getAccessToken();

        $url = rtrim(config('movixtech.url'), '/') . '/' . ltrim($endpoint, '/');

        $response = Http::withToken($token)
            ->acceptJson()
            ->contentType('application/json')
            ->send(strtoupper($method), $url, [
                'json' => $data
            ]);

        // If token expired
        if ($response->status() == 401) {

            $json = $response->json();

            if (($json['code'] ?? null) == 'token_not_valid') {

                $token = $this->refreshToken();

                $response = Http::withToken($token)
                    ->acceptJson()
                    ->contentType('application/json')
                    ->send(strtoupper($method), $url, [
                        'json' => $data
                    ]);
            }
        }

        return $response->json();
    }

    /**
    * Login
    */
    public function login()
    {
        $response = Http::asForm()->post(
            config('movixtech.url') . '/api/v1/auth/login/',
            [
                'email'    => config('movixtech.email'),
                'password' => config('movixtech.password'),
            ]
        );

        /**
         * If login failed
         */
        if (!$response->successful()) {

            $error = $response->json();

            throw new Exception(
                $error['detail'] ?? 'Invalid email or password'
            );
        }

        $data = $response->json();

        Cache::put(
            'movix_access_token',
            $data['access'],
            now()->addMinutes(15)
        );

        Cache::put(
            'movix_refresh_token',
            $data['refresh'],
            now()->addDays(7)
        );

        return $data['access'];
    }

    /**
     * Get Access Token
    */
    public function getAccessToken()
    {
        return Cache::get('movix_access_token') ?? $this->login();
    }

    /**
    * Refresh Token
    */
    public function refreshToken()
    {
        $refreshToken = Cache::get('movix_refresh_token');

        $response = Http::asForm()->post(
            config('movixtech.url') . '/api/v1/auth/refresh-token/',
            [
                'refresh' => $refreshToken
            ]
        )->json();

        Cache::put(
            'movix_access_token',
            $response['access'],
            now()->addMinutes(15)
        );

        Cache::put(
            'movix_refresh_token',
            $response['refresh'],
            now()->addDays(7)
        );

        return $response['access'];
    }


    public function createCaseAndGetPresignedLinks($clientName, $note){
        $result = [];
        $data = [
            'note'   => $note,
            'client' => $clientName,
        ];

        $caseDetails = $this->movixRequest( 'POST', '/api/v1/base/cases/', $data);

        if (empty($caseDetails['case_id'])) {
            return [
                'status' => false,
                'message' => 'Case creation failed'
            ];
        }

        $caseId = $caseDetails['case_id'];
        $presignedLinks = $this->getPresignedLinks($caseId);
        $result['case_id'] = $caseId;
        $result['presigned_links'] = $presignedLinks;

        return $result;
    }

     /**
     * Get Presigned Links
     */
    public function getPresignedLinks($caseId)
    {
        return $this->movixRequest(
            'POST',
            "/api/v1/base/cases/{$caseId}/presigned-links/",
            []
        );
    }

}
