<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Jobs\SendmailCancelDMOrderJob;
use App\Jobs\SendmailConfirmDMOrderJob;
use App\Models\Patients;
use App\Models\PatientTreatmentPlan;
use Illuminate\Http\Request;
use App\Services\PatientsService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use CURLFile;
use Hashids\Hashids;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isNull;

class PatientsController extends Controller
{
    protected $patientsService;
    public $hashids;
    public function __construct(PatientsService $patientsService)
    {
        $this->patientsService = $patientsService;
        $this->hashids = new Hashids();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return $this->patientsService->getPatients($request);
        }
        $statusOptions = PatientTreatmentPlan::where('is_deleted', 0)
                        ->distinct()
                        ->pluck('status');
        $caseHolderOptions = PatientTreatmentPlan::where('is_deleted', 0)
                        ->distinct()
                        ->pluck('case_holder');
        return view('doctor.patients.index', compact('statusOptions', 'caseHolderOptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function orderFromDentalMonitoring(Request $request)
    {
         // ✅ Check if doctor_id is set
        if (empty(Auth::user()->doctor_id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Doctor ID is missing. Please assign a doctor before creating the order. You can update it from My Profile.',
            ], 400);
        }

        // ✅ Validate input
        $request->validate([
            'patient_id' => 'required',
            'p_treatment_plans_id' => 'required',
            'dental_patient_id' => 'required',
        ]);

        // 1. Get previous plan
        $previousPlan = DB::table('p_treatment_plans as tp')
            ->join('patients as p', 'tp.patient_id', '=', 'p.id')
            ->where('tp.is_deleted', 0)
            ->where('tp.patient_id', $request->patient_id)
            ->where('tp.id', '!=', $request->p_treatment_plans_id)
            ->select('tp.*', 'p.first_name', 'p.last_name')
            ->orderByDesc('tp.id')
            ->first();

        if (!$previousPlan) {
            return response()->json(['error' => 'Previous treatment plan not found'], 404);
        }

        // 2. Get current plan
        $currentPlan = DB::table('p_treatment_plans as tp')
            ->join('patients as p', 'tp.patient_id', '=', 'p.id')
            ->where('tp.id', $request->p_treatment_plans_id)
            ->where('tp.is_deleted', 0)
            ->select('tp.*', 'p.id as patient_id')
            ->first();

        if (!$currentPlan) {
            return response()->json(['error' => 'Current plan not found'], 404);
        }

        $currentStage = $currentPlan->lost_track_at_number;

        // 3. Build JSON payload (only files that exist will be included)
        $filesPayload = [];
        if ($request->input('manullay_upload') === 'yes') {
            $patientFolder = storage_path("PatientFiles/Patient{$previousPlan->patient_id}");
            // Store uploaded STL files temporarily
             // Ensure directory exists
            if (!File::exists($patientFolder)) {
                File::makeDirectory($patientFolder, 0775, true);
            }

            // Generate file names (same format as your existing storage)
            $upperFileName = 'upper_arch_' . time() . '.stl';
            $lowerFileName = 'lower_arch_' . time() . '.stl';

            // Move uploaded files to that directory
            $request->file('upper_arch_scan')->move($patientFolder, $upperFileName);
            $request->file('lower_arch_scan')->move($patientFolder, $lowerFileName);

            // Build full paths for later use
            $initialUpper = "{$patientFolder}/{$upperFileName}";
            $initialLower = "{$patientFolder}/{$lowerFileName}";

            // Update file payload for DM API
            $filesPayload['initial_intra_oral_scan'] = [
                'mx' => ['file_name' => $upperFileName],
                'md' => ['file_name' => $lowerFileName],
            ];

        } else {
            /**
             * ✅ CASE 2: Use Previous Plan STL Files
             */
            $initialUpper = storage_path("PatientFiles/Patient{$previousPlan->patient_id}/{$previousPlan->fl_upper_arch}");
            $initialLower = storage_path("PatientFiles/Patient{$previousPlan->patient_id}/{$previousPlan->fl_lower_arch}");

            if (file_exists($initialUpper) && file_exists($initialLower)) {
                $filesPayload['initial_intra_oral_scan'] = [
                    'mx' => ['file_name' => basename($initialUpper)],
                    'md' => ['file_name' => basename($initialLower)],
                ];
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Initial intra-oral scan files are missing.',
                ], 400);
            }
        }


        // Current stage scans (downloaded from Google Drive earlier)
        $stageFiles = $this->downloadStageFiles($previousPlan->treatment_link, $currentStage);

        if (!empty($stageFiles['upper']) && !empty($stageFiles['lower'])) {
            $filesPayload["stage_{$currentStage}"] = [
                'mx' => ['file_name' => basename($stageFiles['upper'])],
                'md' => ['file_name' => basename($stageFiles['lower'])],
            ];
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Stage {$currentStage} scan files are missing.Please check treatment files.",
            ], 400);
        }

        $orderData = [
            'total_stage' => $previousPlan->aligner_steps,
            'treatment_context' => 'mid_course',
            'manufacturer_id' => 'secret_align',
            'patient_id' => "profile:" . $request->dental_patient_id,
            'current_stage' => $currentStage,
            'doctor_id' => "profile:" . Auth::user()->doctor_id,
            'attachments_and_buttons_handling' => $request->keep_attachments_stl,
            'files' => $filesPayload,
        ];

		// 4. Send multipart request
        $http = Http::timeout(600)->asMultipart()
            ->withHeaders([
                'x-dm-api-key' => config('webhook.x-dm-api-key'),
                'Accept' => 'application/json',
            ]);

		$http->attach('order_creation_form', json_encode($orderData), 'order.json');

		$attachedFiles = [];

		// Attach actual STL files (use 'files' key per DM docs/Postman example)
		if (isset($filesPayload['initial_intra_oral_scan'])) {
			$http->attach("files", file_get_contents($initialUpper), basename($initialUpper));
			$http->attach("files", file_get_contents($initialLower), basename($initialLower));
			$attachedFiles[] = basename($initialUpper);
			$attachedFiles[] = basename($initialLower);
		}
		if (isset($filesPayload["stage_{$currentStage}"])) {
			$http->attach("files", file_get_contents($stageFiles['upper']), basename($stageFiles['upper']));
			$http->attach("files", file_get_contents($stageFiles['lower']), basename($stageFiles['lower']));
			$attachedFiles[] = basename($stageFiles['upper']);
			$attachedFiles[] = basename($stageFiles['lower']);
		}

		Log::info('DM smartstls request', [
			'current_stage' => $currentStage,
			'files_payload' => $orderData['files'],
			'attached_files' => $attachedFiles,
		]);

		$response = $http->post(config('webhook.dm-api-url').'/v2/orders/smartstls');

        // cleanup temp stage files
        if (isset($stageFiles['upper'])) @unlink($stageFiles['upper']);
        if (isset($stageFiles['lower'])) @unlink($stageFiles['lower']);
        $responseData = $response->json();
        if (!isset($responseData['code'])) {
            DB::table('p_treatment_plans')->where('id', $currentPlan->id)->update([
                "dm_patient_id" => $request->dental_patient_id,
                "dm_order_details" => json_encode($responseData),
                "dm_order_completed" => '0',
                "dm_order_id" => $responseData['order_id'],
                "dm_order_status" => 'orderPlaced',
            ]);
            $details = [
                'subject' => 'Smart STLs Request sent to DM.',
                'title' => 'Smart STLs Request sent to DM.',
                'doctor_name' => Auth::user()->first_name." ".Auth::user()->last_name,
                'patient_name' => $previousPlan->first_name." ".$previousPlan->last_name,
                'email' => Auth::user()->email,
                'orderId' => $responseData['order_id'] ?? null,
            ];
            SendmailConfirmDMOrderJob::dispatch($details);
            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully.we\'ll notify you when the order is ready.',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $responseData['message'],
            ], 400);
        }
    }


    public function updateOrderFromDentalMonitoring(Request $request){
        // dd($request->all());
         if (empty($request->dmOrderId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dedental monitoring Order ID is missing.',
            ], 400);
        }

        $pTreatmentPlan  = DB::table('p_treatment_plans as tp')
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->join('users as dr', 'dr.id', '=', 'p.user_id')
                ->where('dm_order_completed', '0')
                ->where("dm_order_id", $request->dmOrderId)
                ->select("tp.*", "p.first_name", "p.last_name", "p.id as patinetId", "dr.first_name as doctor_first_name", "dr.last_name as doctor_last_name", "dr.email as doctor_email")
                ->first();

        if (!$pTreatmentPlan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Treatment plan not found.',
            ], 400);
        }

        $iosStatuses = [
            'OrderStatusChangedToWaitingForNewFilesIOSIncorrect',
            'OrderStatusChangedToWaitingForNewFilesIOSCorrupted',
            'OrderStatusChangedToWaitingForNewFilesIOSUnusable',
            'OrderStatusChangedToOrderRejectedAnatomicalChanges',
            'OrderStatusChangedToOrderRejectedAdditionalTeeth',
        ];

        $stageFileStatuses = [
            'OrderStatusChangedToWaitingForNewFilesStageFileIncorrect',
            'OrderStatusChangedToWaitingForNewFilesStageFileCorrupted',
            'OrderStatusChangedToWaitingForNewFilesStageFileUnusable',
            'OrderStatusChangedToWaitingForNewFilesAlignerNumberIncorrect'
        ];


        // Determine which type of files to process
        if (in_array($pTreatmentPlan->dm_order_status, $iosStatuses)) {
            $upper = $request->file('upper_arch_scan');
            $lower = $request->file('lower_arch_scan');
            $formKey = 'initial_intra_oral_scan';
        } elseif (in_array($pTreatmentPlan->dm_order_status, $stageFileStatuses)) {
            $upper = $request->file('upper_arch_stage_file');
            $lower = $request->file('lower_arch_stage_file');
            $formKey = "stage_{$pTreatmentPlan->lost_track_at_number}";
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid DM order status for update.',
            ], 400);
        }

        // Validate files
        if (!$upper || !$lower) {
            return response()->json([
                'status' => 'error',
                'message' => 'Both upper and lower arch scan files are required.',
            ], 400);
        }

        // Build JSON payload
        $orderModificationForm = [
            'files' => [
                $formKey => [
                    'mx' => ['file_name' => $upper->getClientOriginalName()],
                    'md' => ['file_name' => $lower->getClientOriginalName()],
                ],
            ],
        ];

        try {
            $response = Http::timeout(600)
                ->withHeaders([
                    'x-dm-api-key' => config('webhook.x-dm-api-key'),
                    'Accept' => 'application/json',
                ])
                ->send('PATCH', config('webhook.dm-api-url') . "/v2/orders/smartstls/{$request->dmOrderId}", [
                    'multipart' => [
                        [
                            'name' => 'order_modification_form',
                            'contents' => json_encode($orderModificationForm),
                        ],
                        [
                            'name' => 'files',
                            'contents' => fopen($upper->getRealPath(), 'r'),
                            'filename' => $upper->getClientOriginalName(),
                        ],
                        [
                            'name' => 'files',
                            'contents' => fopen($lower->getRealPath(), 'r'),
                            'filename' => $lower->getClientOriginalName(),
                        ],
                    ],
                ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Request to Dental Monitoring failed.',
                'details' => $e->getMessage(),
            ], 500);
        }

        $responseCode = $response->status();
        $responseBody = $response->json();

        if ($responseCode >= 200 && $responseCode < 300) {
             DB::table('p_treatment_plans')->where('id', $pTreatmentPlan->id)->update([
                "dm_order_details" => json_encode($responseBody),
                "dm_order_status" => 'orderUpadated',
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Order successfully updated in Dental Monitoring.',
                'response' => $responseBody,
            ], $responseCode);
        }

        return response()->json([
            'status' => 'error',
            'message' => $responseBody['message'] ?? null,
            'details' => $responseBody,
        ], $responseCode);

        // if (in_array($pTreatmentPlan->dm_order_status, $iosStatuses)) {
        //     $upper = $request->file('upper_arch_scan');
        //     $lower = $request->file('lower_arch_scan');

        //     if (!$upper || !$lower) {
        //         return response()->json([
        //             'status' => 'error',
        //             'message' => 'Both upper and lower arch scan files are required.',
        //         ], 400);
        //     }
        //     // Build JSON payload
        //     $orderModificationForm = [
        //         'files' => [
        //             'initial_intra_oral_scan' => [
        //                 'mx' => ['file_name' => $upper->getClientOriginalName()],
        //                 'md' => ['file_name' => $lower->getClientOriginalName()],
        //             ],
        //         ],
        //     ];
        //     // dd($orderModificationForm);
        //     // ✅ Equivalent of your working cURL
        //     $response = Http::withHeaders([
        //             'x-dm-api-key' => config('webhook.x-dm-api-key'),
        //             'Accept' => 'application/json',
        //         ])
        //         ->send('PATCH', config('webhook.dm-api-url')."/v2/orders/smartstls/{$request->dmOrderId}", [
        //             'multipart' => [
        //                 [
        //                     'name' => 'order_modification_form',
        //                     'contents' => json_encode($orderModificationForm),
        //                 ],
        //                 [
        //                     'name' => 'files',
        //                     'contents' => fopen($upper->getRealPath(), 'r'),
        //                     'filename' => $upper->getClientOriginalName(),
        //                 ],
        //                 [
        //                     'name' => 'files',
        //                     'contents' => fopen($lower->getRealPath(), 'r'),
        //                     'filename' => $lower->getClientOriginalName(),
        //                 ],
        //             ],
        //         ]);

        //         $responseCode = $response->status(); // HTTP status returned by DM API
        //         $responseBody = $response->json();   // decoded JSON body

        //         if ($responseCode >= 200 && $responseCode < 300) {
        //             return response()->json([
        //                 'status' => 'success',
        //                 'message' => 'Order successfully updated in Dental Monitoring.',
        //                 'response' => $responseBody,
        //             ], $responseCode); // return same status code as DM API
        //         } else {
        //             return response()->json([
        //                 'status' => 'error',
        //                 'message' => 'Dental Monitoring API request failed.',
        //                 'details' => $responseBody,
        //             ], $responseCode); // return same status code as DM API
        //         }
        // } elseif (in_array($pTreatmentPlan->dm_order_status, $stageFileStatuses)) {
        //     $upper = $request->file('upper_arch_stage_file');
        //     $lower = $request->file('lower_arch_stage_file');

        //     if (!$upper || !$lower) {
        //         return response()->json([
        //             'status' => 'error',
        //             'message' => 'Both upper and lower arch scan files are required.',
        //         ], 400);
        //     }
        //     // Build JSON payload
        //     $orderModificationForm = [
        //         'files' => [
        //             "stage_{$pTreatmentPlan->lost_track_at_number}" => [
        //                 'mx' => ['file_name' => $upper->getClientOriginalName()],
        //                 'md' => ['file_name' => $lower->getClientOriginalName()],
        //             ],
        //         ],
        //     ];
        //     // dd($orderModificationForm);
        //     // ✅ Equivalent of your working cURL
        //     $response = Http::withHeaders([
        //             'x-dm-api-key' => config('webhook.x-dm-api-key'),
        //             'Accept' => 'application/json',
        //         ])
        //         ->send('PATCH', config('webhook.dm-api-url')."/v2/orders/smartstls/{$request->dmOrderId}", [
        //             'multipart' => [
        //                 [
        //                     'name' => 'order_modification_form',
        //                     'contents' => json_encode($orderModificationForm),
        //                 ],
        //                 [
        //                     'name' => 'files',
        //                     'contents' => fopen($upper->getRealPath(), 'r'),
        //                     'filename' => $upper->getClientOriginalName(),
        //                 ],
        //                 [
        //                     'name' => 'files',
        //                     'contents' => fopen($lower->getRealPath(), 'r'),
        //                     'filename' => $lower->getClientOriginalName(),
        //                 ],
        //             ],
        //         ]);

        //         $responseCode = $response->status(); // HTTP status returned by DM API
        //         $responseBody = $response->json();   // decoded JSON body

        //         if ($responseCode >= 200 && $responseCode < 300) {
        //             return response()->json([
        //                 'status' => 'success',
        //                 'message' => 'Order successfully updated in Dental Monitoring.',
        //                 'response' => $responseBody,
        //             ], $responseCode); // return same status code as DM API
        //         } else {
        //             return response()->json([
        //                 'status' => 'error',
        //                 'message' => 'Dental Monitoring API request failed.',
        //                 'details' => $responseBody,
        //             ], $responseCode); // return same status code as DM API
        //         }
        // } else {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Invalid DM order status for update.',
        //     ], 400);
        // }


    }

    /**
     * Download STL files for given stage from Google Drive link.
     */
    protected function downloadStageFiles($driveFolderUrl, $stageNumber)
    {
        $files = listPublicDriveFiles($driveFolderUrl);
        $stageNumber = str_pad($stageNumber, 2, '0', STR_PAD_LEFT);

        $stageFiles = array_filter($files, fn($f) =>
            // str_contains($f['name'], "_Step_{$stageNumber}")
            str_contains($f['name'], "_Step_{$stageNumber}") &&
            str_ends_with(strtolower($f['name']), '.stl')
        );
        $tmp = [];
        foreach ($stageFiles as $file) {
            $url = "https://drive.google.com/uc?export=download&id={$file['id']}";
            $path = sys_get_temp_dir() . '/' . $file['name'];
            // If file already exists, delete it
            if (file_exists($path)) {
                unlink($path);
            }
            file_put_contents($path, file_get_contents($url));

            if (str_starts_with($file['name'], 'U_')) $tmp['upper'] = $path;
            if (str_starts_with($file['name'], 'L_')) $tmp['lower'] = $path;
        }
        return $tmp;
    }

    public function cancelOrderFromDentalMonitoring(Request $request){
         $currentPlan = DB::table('p_treatment_plans as tp')
            ->join('patients as p', 'tp.patient_id', '=', 'p.id')
            ->where('tp.id', $request->p_treatment_plans_id)
            ->where('tp.patient_id', $request->patient_id)
            ->where('tp.is_deleted', 0)
            ->select('tp.*', 'p.id as patient_id', 'p.first_name', 'p.last_name')
            ->first();

        if (!$currentPlan) {
            return response()->json(['error' => 'Current plan not found'], 404);
        }
        $dmOrderDetails = json_decode($currentPlan->dm_order_details);
        if (!$dmOrderDetails || empty($dmOrderDetails->order_id)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Order details not found. Please try again later.',
            ], 404);
        }
        $http = Http::timeout(120)
            ->asMultipart()
            ->withHeaders([
                'x-dm-api-key' => config('webhook.x-dm-api-key'),
                'Accept' => 'application/json',
            ]);
        $response = $http->get(config('webhook.dm-api-url').'/v2/orders/smartstls/'.$dmOrderDetails->order_id);
        $responseData = $response->json();
        if (!isset($responseData['code'])) {
            if ($responseData['order_status'] == 'order_cancelled') {
                DB::table('p_treatment_plans')->where('id', $currentPlan->id)->update([
                    "dm_order_details" => null,
                    "dm_order_completed" => '0',
                    "dm_order_id" => null,
                    "dm_order_status" => 'OrderStatusChangedToOrderCancelled',
                ]);
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Order has already been cancelled.',
                ], 200);
            }

            $httpDelete = Http::timeout(120)
                ->asMultipart()
                ->withHeaders([
                    'x-dm-api-key' => config('webhook.x-dm-api-key'),
                    'Accept' => 'application/json',
                ]);
            $responseDelete = $httpDelete->delete(config('webhook.dm-api-url').'/v2/orders/smartstls/'.$dmOrderDetails->order_id);
            $responseDataDelete = $responseDelete->json();

            if (!isset($responseData['code'])) {

                DB::table('p_treatment_plans')->where('id', $currentPlan->id)->update([
                    "dm_order_details" => null,
                    "dm_order_completed" => '0',
                    "dm_order_id" => null,
                    "dm_order_status" => 'OrderStatusChangedToOrderCancelled',
                ]);

                $details = [
                    'subject'      => 'Dental Monitoring Order Cancelled : Order Cancelled for Patient ' . $currentPlan->first_name . ' ' . $currentPlan->last_name,
                    'title'        => 'Dental Monitoring Order Cancelled : Order Cancelled for Patient ' . $currentPlan->first_name . ' ' . $currentPlan->last_name,
                    'doctor_name'  => Auth::user()->first_name . " " . Auth::user()->last_name,
                    'email'        => Auth::user()->email,
                    'patient_name' => $currentPlan->first_name . " " . $currentPlan->last_name,
                    'orderId'      => $dmOrderDetails->order_id,
                ];
                SendmailCancelDMOrderJob::dispatch($details);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Order successfully cancelled',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'An error occurred. Please try again after some time.',
                ], 404);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred. Please try again after some time.',
            ], 404);
        }
    }

    public function updateNewScan(Request $request, $phase){
        $data = [];
        $data['model'] = $request->get('modal') ?? '';
        $whereClauses = [["tp.id", $this->hashids->decode($phase)], ["tp.is_deleted", 0],];

        $patient = DB::table('p_treatment_plans as tp')
            ->where($whereClauses)
            //->where('tp.is_submitted', 1)
            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", '=', "p.id")
                    ->where('p.is_deleted', 0);
                if (Auth::user()->role == 'doctor') {
                    $join->where('p.user_id', Auth::user()->id);
                }
            })
            ->leftJoin("users as l", function ($join) {
                $join->on("tp.lab", "=", "l.id")
                    ->where("l.role", "lab");
            })
            ->select("tp.*", "p.id as patientId", "p.pricing_package", "p.setup_type", "p.is_setup_type_approved", "p.first_name", "p.last_name", "p.dob", "p.user_id", "l.first_name as lab_first_name", "l.last_name as lab_last_name")
            ->first();
        $data['patient'] = $patient;
        $mode = 'update';
        $hashids = new Hashids();
        $hashCode = $hashids->encode($patient->id);
        return view("patients.update-new-scan", compact("patient", "data", "hashCode","mode"));
    }

    public function updateNewScanSubmit(Request $request){
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
        dd($patientDetails);
        if (!$patientDetails || $patientDetails->treatmentPlans->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Patient or treatment plan not found'
            ], 404);
        }

        $plan = $patientDetails->treatmentPlans->first();

        $caseId = null;
        $note = null;
        $upperFile = null;
        $lowerFile = null;
        $clientName = $patientDetails->first_name . ' ' . $patientDetails->last_name;

        // ✅ Decide which scan to use
        if (!empty($plan->fl_upper_arch) && !empty($plan->fl_lower_arch)) {
            $upperFile = $plan->fl_upper_arch;
            $lowerFile = $plan->fl_lower_arch;
            $note = 'Primary Scan';
        }
        elseif (!empty($plan->optional_fl_upper_arch) && !empty($plan->optional_fl_lower_arch)) {
            $upperFile = $plan->optional_fl_upper_arch;
            $lowerFile = $plan->optional_fl_lower_arch;
            $note = 'Optional Scan';
            $clientName .= ' (Optional)';
        }
        else {
            return response()->json([
                'status' => false,
                'message' => 'No valid scan files found'
            ], 400);
        }

        // ✅ Single call only
        $result  = $this->createCase(
            $request->patient_id,
            $request->treatment_plan_id,
            $upperFile,
            $lowerFile,
            $clientName,
            $note
        );
        if (!$result['status']) {
            return response()->json([
                'status' => false,
                'message' => $result['message']
            ], 500);
        }
        $caseId = $result['case_id'];
        $runCase = $this->runCase($caseId);
        if (empty($runCase) || (isset($runCase['success']) && !$runCase['success'])) {
            return response()->json([
                'status' => false,
                'message' => 'Case created but failed to run',
                'case_id' => $caseId
            ], 500);
        }

        // $objAudittrails = new Audittrails();
        // $saveAudittrails = $objAudittrails->addAudittrails( $request->patient_id, $request->treatment_plan_id, "Patient Scan data Updated", 'D', null, $data);

        return response()->json([
            'status' => true,
            'message' => 'Case created and started successfully',
            'case_id' => $caseId
        ]);
    }
}
