<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\PatientTreatmentPlan;
use App\Models\Patients;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class MovixtechController extends Controller
{

    // public function movixtech_create_case(Request $request)
    // {
    //     MovixProcessJob::dispatch([
    //         'patient_id' => $request->patient_id,
    //         'treatment_plan_id' => $request->treatment_plan_id,
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Movix process started'
    //     ]);
    // }

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

    public function createCase($clientName, $note = null){
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
        return [
                'status' => true,
                'message' => 'Case created successfully',
                'data' => $caseDetails,
        ];
        // $caseId = $caseDetails['case_id'];
    }

    public function createCaseAndGetPresignedLinks($clientName, $note, $caseType = 'Primary Scan'){
        dd($clientName, $note, $caseType);
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
    }


    public function processMovix(Request $request)
    {
        $patientDetails = Patients::with([
            'treatmentPlans' => function ($query) use ($request) {
                $query->where('patient_id', $request->patient_id)
                    ->where('id', $request->treatment_plan_id)
                    ->select(
                        'id',
                        'patient_id',
                        'primary_movixtech_status',
                        'optional_movixtech_status',
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

        if (!$patientDetails || $patientDetails->treatmentPlans->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Patient or treatment plan not found'
            ], 404);
        }

        $plan = $patientDetails->treatmentPlans->first();
        // ❌ Both scans missing
        if (empty($plan->fl_upper_arch) && empty($plan->fl_lower_arch) &&
            empty($plan->optional_fl_upper_arch) && empty($plan->optional_fl_lower_arch))
        {
            return response()->json([
                'status' => false,
                'message' => 'No valid scan files found'
            ], 400);

        }
        $clientName = $patientDetails->first_name . ' ' . $patientDetails->last_name;
        $patientId = $patientDetails->id;
        // ✅ Primary scan data
        if (!empty($plan->fl_upper_arch) || !empty($plan->fl_lower_arch)) {
            $primaryUpperFile = $plan->fl_upper_arch;
            $primaryLowerFile = $plan->fl_lower_arch;
            $primaryCaseId = $plan->primary_case_id;
            $primaryMovixtechStatus = $plan->primary_movixtech_status;
            $createCaseResponse = $this->createCase($clientName, 'Primary Scan');

             if (!$createCaseResponse['status']) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to create case for primary scan: ' . $createCaseResponse['message']
                ], 500);
            }
            $primaryCaseId = $createCaseResponse['data']['case_id'];
            $presignedLinks = $this->getPresignedLinks($primaryCaseId);
            if (empty($presignedLinks['upper_jaw']['url']) ||  empty($presignedLinks['lower_jaw']['url'])) {
                return [
                    'status' => false,
                    'message' => 'Presigned URL missing'
                ];
            }

            $upperPath = storage_path("PatientFiles/Patient{$patientId}/".$primaryUpperFile);
            $lowerPath = storage_path("PatientFiles/Patient{$patientId}/".$primaryLowerFile);

            if (!file_exists($upperPath) || !file_exists($lowerPath)) {
                return [
                    'status' => false,
                    'message' => 'File not found'
                ];
            }

            $uploadToPresignedUrlUpper = $this->uploadToPresignedUrl($presignedLinks['upper_jaw']['url'], $upperPath);
            $uploadToPresignedUrlLower = $this->uploadToPresignedUrl($presignedLinks['lower_jaw']['url'], $lowerPath);
            if($uploadToPresignedUrlUpper === false || $uploadToPresignedUrlLower === false){
                return [
                    'status' => false,
                    'message' => 'Failed to upload files to presigned URLs'
                ];
            }
            $runCase = $this->runCase($primaryCaseId);

        }

        // ✅ Optional scan data
        if (!empty($plan->optional_fl_upper_arch) || !empty($plan->optional_fl_lower_arch)) {
            $optionalUpperFile = $plan->optional_fl_upper_arch;
            $optionalLowerFile = $plan->optional_fl_lower_arch;
            $optionalCaseId = $plan->optional_scan_case_id;
            $optionalMovixtechStatus = $plan->optional_scan_movixtech_status;
            $createCaseResponse = $this->createCase($clientName, 'Optional Scan');
            if (!$createCaseResponse['status']) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to create case for optional scan: ' . $createCaseResponse['message']
                ], 500);
            }
            $optionalCaseId = $createCaseResponse['data']['case_id'];
            $optionalPresignedLinks = $this->getPresignedLinks($optionalCaseId);
            if (empty($optionalPresignedLinks['upper_jaw']['url']) ||  empty($optionalPresignedLinks['lower_jaw']['url'])) {
                return [
                    'status' => false,
                    'message' => 'Presigned URL missing'
                ];
            }

            $upperPath = storage_path("PatientFiles/Patient{$patientId}/".$optionalUpperFile);
            $lowerPath = storage_path("PatientFiles/Patient{$patientId}/".$optionalLowerFile);

            if (!file_exists($upperPath) || !file_exists($lowerPath)) {
                return [
                    'status' => false,
                    'message' => 'File not found'
                ];
            }

            $uploadToPresignedUrlUpperOptional = $this->uploadToPresignedUrl($optionalPresignedLinks['upper_jaw']['url'], $upperPath);
            $uploadToPresignedUrlLowerOptional = $this->uploadToPresignedUrl($optionalPresignedLinks['lower_jaw']['url'], $lowerPath);
            if($uploadToPresignedUrlUpperOptional === false || $uploadToPresignedUrlLowerOptional === false){
                return [
                    'status' => false,
                    'message' => 'Failed to upload files to presigned URLs'
                ];
            }
            $runOptionalCase = $this->runCase($optionalCaseId);
        }
        return response()->json([
            'status' => true,
            'message' => 'Case created and started successfully',
        ]);
    }


    /**
     * Run Case (Start Processing)
     */
    public function runCase($caseId)
    {
        return $this->movixRequest(
            'POST',
            "/api/v1/services/cases/{$caseId}/run/",
            [],
            true
        );
    }
    public function processMovixOld(Request $request)
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
            if ( !empty($plan->fl_upper_arch) && !empty($plan->fl_lower_arch) ) {
                return $this->createCase(
                    $request->patient_id,
                    $request->treatment_plan_id,
                    $plan->fl_upper_arch,
                    $plan->fl_lower_arch,
                    $patientDetails->first_name . ' ' . $patientDetails->last_name,
                    'Primary Scan'
                );
            }

            // Check optional files
            if ( !empty($plan->optional_fl_upper_arch) &&   !empty($plan->optional_fl_lower_arch) ) {
                return $this->createCase(
                    $request->patient_id,
                    $request->treatment_plan_id,
                    $plan->optional_fl_upper_arch,
                    $plan->optional_fl_lower_arch,
                    $patientDetails->first_name . ' ' . $patientDetails->last_name . ' (Optional)',
                    'Optional Scan'
                );
            }
        }


    }



    public function createCaseOld($patientId, $treatmentPlanId, $upperFile, $lowerFile, $clientName, $note = null)
    {
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

        $objPatientTreatmentPlan = PatientTreatmentPlan::find($treatmentPlanId);
        if ($objPatientTreatmentPlan) {
            $objPatientTreatmentPlan->primary_case_id = $caseId;
            $objPatientTreatmentPlan->primary_client = $clientName;
            $objPatientTreatmentPlan->primary_note = $note;
            $objPatientTreatmentPlan->primary_movix_note = null;
            $objPatientTreatmentPlan->save();
        }

        $presignedLinks = $this->getPresignedLinks($caseId);

        if (
            empty($presignedLinks['upper_jaw']['url']) ||
            empty($presignedLinks['lower_jaw']['url'])
        ) {
            return [
                'status' => false,
                'message' => 'Presigned URL missing'
            ];
        }

        $upperPath = storage_path("PatientFiles/Patient{$patientId}/".$upperFile);
        $lowerPath = storage_path("PatientFiles/Patient{$patientId}/".$lowerFile);

        if (!file_exists($upperPath) || !file_exists($lowerPath)) {
            return [
                'status' => false,
                'message' => 'File not found'
            ];
        }

        $this->uploadToPresignedUrl($presignedLinks['upper_jaw']['url'], $upperPath);
        $this->uploadToPresignedUrl($presignedLinks['lower_jaw']['url'], $lowerPath);

        return [
            'status' => true,
            'case_id' => $caseId
        ];
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
            return false;
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

    /**
     * Get Case Summary
     */
    public function getCaseSummary($caseId, $language = 'en')
    {
        return $this->movixRequest(
            'POST',
            "/api/v1/services/cases/{$caseId}/summary/",
            [
                'code' => $language
            ],
            true // form-data
        );
    }

    /**
     * Get Viewer Link
     */
    public function getViewerLink($caseId)
    {
        return $this->movixRequest(
            'POST',
            '/api/v1/viewer/links/',
            [
                'case_id' => $caseId
            ],
            true // form-data
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

        if ($request->webhook_type === 'case_done') {
            $caseId = $request->case_id;
            if (empty($caseId)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Missing case_id'
                ], 200);
            }
            // ✅ Find record
            $case = PatientTreatmentPlan::where('primary_case_id', $caseId)->first();

            if (!$case) {
                return response()->json([
                    'status' => false,
                    'message' => 'Case not found'
                ], 404);
            }

            // ✅ Call summary API
            $summaryResponse = $this->getCaseSummary($caseId);
            // ✅ Handle response safely
            if (!$summaryResponse) {
                return response()->json([
                    'status' => false,
                    'message' => 'Summary API failed'
                ], 500);
            }

            $message = $summaryResponse['message'] ?? null;
            // ✅ If still processing (202)
            if ($message === null) {

                // Could mean:
                // - No issues OR
                // - Not ready yet

                // Optional: check tasks to confirm
                $tasks = $request->tasks ?? [];

                $allDone = collect($tasks)->every(function ($task) {
                    return strtolower($task['status'] ?? '') === 'done';
                });

                if (!$allDone) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Summary not ready yet'
                    ], 200);
                }
            }

            // ✅ Prepare update data
            $updateData = [
                'primary_movix_note' => $message,
            ];

            // ✅ Call getViewerLink API
            $getViewerLink = $this->getViewerLink($caseId);
            $logData = [
                'title' => 'getViewerLink',
                'data'     => $getViewerLink,
            ];
            File::append(
                $filePath,
                json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL
            );
            // ✅ Append (NOT replace)
            if (!empty($getViewerLink) && !empty($getViewerLink['url'])) {

                $updateData['primary_movix_link'] = $getViewerLink['url'];
                $updateData['primary_movix_link_expires_at'] = Carbon::parse($getViewerLink['expires_at']);
            }
            // ✅ Single DB update (better)
            $case->update($updateData);

            return response()->json([
                'status' => true,
                'message' => 'Webhook processed successfully'
            ], 200);
        }

        // ❌ Unknown webhook
        return response()->json([
            'status' => false,
            'message' => 'Invalid webhook type'
        ], 200);
    }
}
