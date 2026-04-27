<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Jobs\MovixProcessJob;
use App\Models\Movixpatient;
use App\Models\Patients;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class MovixtechController extends Controller
{

    public function movixtech_create_case(Request $request)
    {
        MovixProcessJob::dispatch([
            'patient_id' => $request->patient_id,
            'treatment_plan_id' => $request->treatment_plan_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Movix process started'
        ]);
    }

    public function processMovix(Request $request)
    {
        $logPath = storage_path('logs/processMovix');

        if (!File::exists($logPath)) {
            File::makeDirectory($logPath, 0777, true, true);
        }

        $filePath = $logPath . '/' . now()->format('Y-m-d') . '.log';

        $logData = [
            'datetime' => now()->format('Y-m-d H:i:s'),
            'data'     => $request->all(),
        ];

        File::append(
            $filePath,
            json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL
        );

        dd($request->all());

        $patientDetails = Patients::with([
            'treatmentPlans' => function ($query) use ($request) {
                $query->where('patient_id', $request->patient_id)
                    ->where('id', $request->treatment_plan_id)
                    ->select(
                        'id',
                        'patient_id',
                        'fl_upper_arch',
                        'fl_lower_arch',
                        'optional_fl_upper_arch',
                        'optional_fl_lower_arch'
                    );
            }
        ])
        ->select('id', 'first_name', 'last_name')
        ->where('id', $request->patient_id)
        ->first();

        if ($patientDetails && $patientDetails->treatmentPlans->count() > 0) {

            $plan = $patientDetails->treatmentPlans->first();

            // Check main files
            if (
                !empty($plan->fl_upper_arch) &&
                !empty($plan->fl_lower_arch)
            ) {
                $this->createCase(
                    $request->patient_id,
                    $request->treatment_plan_id,
                    $plan->fl_upper_arch,
                    $plan->fl_lower_arch,
                    $patientDetails->first_name . ' ' . $patientDetails->last_name,
                    'Primary Scan'
                );
            }

            // Check optional files
            if (
                !empty($plan->optional_fl_upper_arch) &&
                !empty($plan->optional_fl_lower_arch)
            ) {
                $this->createCase(
                    $request->patient_id,
                    $request->treatment_plan_id,
                    $plan->optional_fl_upper_arch,
                    $plan->optional_fl_lower_arch,
                    $patientDetails->first_name . ' ' . $patientDetails->last_name . ' (Optional)',
                    'Optional Scan'
                );
            }
        }

        dd($patientDetails);
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


    public function createCase($patientId, $treatmentPlanId, $upperFile, $lowerFile, $clientName, $note = null)
    {
        $data = [
            'note'   => $note,
            'client' => $clientName,
        ];

        $caseDetails = $this->movixRequest( 'POST', '/api/v1/base/cases/', $data);

        Movixpatient::updateOrCreate(
            [
                'patient_id'            => $patientId,
                'p_treatment_plans_id' => $treatmentPlanId,
            ],
            [
                'case_id' => $caseDetails['case_id'] ?? null,
                'client'    => $clientName,
                'note'    => $note,
                'movix_note'    => null,
            ]
        );

        // Step 2: Get Presigned URLs
        $presignedLinks = $this->getPresignedLinks($caseDetails['case_id']);

        // Step 3: Upload Upper STL
        $this->uploadToPresignedUrl(
            $presignedLinks['upper_jaw']['url'],
            storage_path("PatientFiles/Patient{$patientId}/".$upperFile) // file path
        );

        // Step 4: Upload Lower STL
        $this->uploadToPresignedUrl(
            $presignedLinks['lower_jaw']['url'],
            storage_path("PatientFiles/Patient{$patientId}/".$lowerFile)
            // public_path($lowerFile)
        );
        $getCases = $this->getCases();
        dd($getCases);
    }

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

    /**
     * Upload file to Google Storage Presigned URL
     */
    public function uploadToPresignedUrl($url, $filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception("File not found: " . $filePath);
        }

        $response = Http::withHeaders([
                'Content-Type' => 'application/octet-stream',
            ])
            ->withBody(
                fopen($filePath, 'r'),
                'application/octet-stream'
            )
            ->put($url);

        if (!$response->successful()) {
            throw new Exception(
                'Upload failed: ' .
                $response->status() .
                ' - ' .
                $response->body()
            );
        }

        return true;
    }

    public function getCases()
    {
        $response = $this->movixRequest(
            'GET',
            '/api/v1/base/cases/'
        );

        return $response;
    }

    /**
    * Create Webhook
    */
    public function createWebhook()
    {
        $data = [
            'type'     => 'case_done',
            'endpoint' => 'https://test.secretalign-user.com/movix-webhook',
            'token'    => 'WebhookSecret_2026_X7mQ9vLp2RtK8cZa5NyD1wEf6HuJs3Bn',
        ];

        return $this->movixRequest(
            'POST',
            '/api/v1/auth/webhooks/',
            $data,
            true
        );
    }

    /**
     * Get Webhook List
     */
    public function getWebhooks()
    {
        return $this->movixRequest(
            'GET',
            '/api/v1/auth/webhooks/',
            [],
            true
        );
    }

    public function movixWebhook(Request $request){
        $logPath = storage_path('logs/processMovix/webhook');

        if (!File::exists($logPath)) {
            File::makeDirectory($logPath, 0777, true, true);
        }

        $filePath = $logPath . '/' . now()->format('Y-m-d') . '.log';

        $logData = [
            'datetime' => now()->format('Y-m-d H:i:s'),
            'data'     => $request->all(),
        ];

        File::append(
            $filePath,
            json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL
        );
    }
}
