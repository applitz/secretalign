<?php

namespace App\Http\Controllers;

use App\Jobs\AskForNewFileToDoctorJob;
use App\Jobs\OrderCanceledJob;
use App\Jobs\OrderCompletedJob;
use App\Jobs\SendMessageGeneratingFilesJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Jobs\WeebhookCalledJob;
use App\Jobs\WeebhookFaildCalledJob;
use App\Jobs\WeebhookSuccessJob;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WeebhookSuccess;
class DmWebhookController extends Controller
{
    public function webhook(Request $request){

        $token = $request->header('X-Webhook-Token');

        if ($token !== config('webhook.secret')) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthorized webhook'
            ], 401); // 401 = Unauthorized
        }

        // Folder path inside storage/logs/webhooks
        $logPath = storage_path('logs/webhooks');

        // If folder not exists create
        if (!File::exists($logPath)) {
            File::makeDirectory($logPath, 0777, true);
        }

        // File name based on date
        $fileName = date('Y-m-d') . '.log';
        $filePath = $logPath . '/' . $fileName;

        // Log content
        $logData = [
            'datetime' => now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            'data' => $request->all(),
        ];

        // Append data to log file
        File::append($filePath, json_encode($logData, JSON_PRETTY_PRINT) . PHP_EOL);
        $details = [
            'subject' => 'Action Required: New Weebhook Called',
            'title' => 'Action Required: New Weebhook Called',
            'email' => 'wisherw064@gmail.com',
            'data' => json_encode($request->all()),
        ];
        WeebhookCalledJob::dispatch($details);

        if ($request->platform === 'dmeu2') {
            $type = $request->input('type');
            if (!$type) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid request: Missing type',
                ], 200);
            }
            $orderResource = $request->input('resource');
            if($orderResource){
                $orderUrl = $orderResource['url'] ?? null;
                if($orderUrl){
                    $orderProcess = $this->getASmartSTLOrder($orderUrl);
                    if ($orderProcess) {
                        $orderId = $orderProcess['order_id'];
                        $pTreatmentPlan  = DB::table('p_treatment_plans as tp')
                                        ->Join("patients as p", function ($join) {
                                            $join->on("tp.patient_id", "=", "p.id")
                                                ->where("p.is_deleted", 0);
                                        })
                                        ->join('users as dr', 'dr.id', '=', 'p.user_id')
                                        ->where('dm_order_completed', '0')
                                        ->where("dm_order_id", $orderId)
                                        ->select("tp.*", "p.first_name", "p.last_name", "p.id as patinetId", "dr.first_name as doctor_first_name", "dr.last_name as doctor_last_name", "dr.email as doctor_email")
                                        ->first();
                        if($pTreatmentPlan && !empty($pTreatmentPlan)){

                            switch ($type) {
                                case "OrderStatusChangedToWaitingForNewFilesStageFileIncorrect":
                                    $res = $this->askForNewFileToDoctor('stage', $pTreatmentPlan, $type);
                                    return response()->json([
                                            'status'  => true,
                                            'message' => "The uploaded stage file is incorrect. Doctor has been notified to re-upload a new one.",
                                        ], 200);
                                    break;

                                case "OrderStatusChangedToWaitingForNewFilesStageFileCorrupted":
                                    $res = $this->askForNewFileToDoctor('stage', $pTreatmentPlan, $type);
                                    return response()->json([
                                            'status'  => true,
                                            'message' => "The uploaded stage file is corrupted and cannot be processed. Doctor has been notified to provide a new file.",
                                        ], 200);
                                    break;

                                case "OrderStatusChangedToWaitingForNewFilesStageFileUnusable":
                                    $res = $this->askForNewFileToDoctor('stage', $pTreatmentPlan, $type);
                                    return response()->json([
                                            'status'  => true,
                                            'message' => "The uploaded stage file is unusable for the treatment process. Doctor has been requested to re-upload a valid file.",
                                        ], 200);
                                    break;

                                case "OrderStatusChangedToWaitingForNewFilesIOSIncorrect":
                                    $res = $this->askForNewFileToDoctor('ios', $pTreatmentPlan, $type);
                                    return response()->json([
                                            'status'  => true,
                                            'message' => "The uploaded IOS (Intraoral Scan) file is incorrect. Doctor has been informed to re-upload the correct file.",
                                        ], 200);
                                    break;

                                case "OrderStatusChangedToWaitingForNewFilesIOSCorrupted":
                                    $res = $this->askForNewFileToDoctor('ios', $pTreatmentPlan, $type);
                                    return response()->json([
                                            'status'  => true,
                                            'message' => "The uploaded IOS (Intraoral Scan) file is corrupted and cannot be used. Doctor has been notified to provide a new one.",
                                        ], 200);
                                    break;

                                case "OrderStatusChangedToWaitingForNewFilesIOSUnusable":
                                    $res = $this->askForNewFileToDoctor('ios', $pTreatmentPlan, $type);
                                    return response()->json([
                                            'status'  => true,
                                            'message' => "The uploaded IOS (Intraoral Scan) file is unusable. Doctor has been requested to upload a new valid file.",
                                        ], 200);
                                    break;

                                case "OrderStatusChangedToWaitingForNewFilesAlignerNumberIncorrect":
                                    $res = $this->askForNewFileToDoctor('alignerNumber', $pTreatmentPlan, $type);
                                    return response()->json([
                                            'status'  => true,
                                            'message' => "The aligner number information appears to be incorrect. Doctor has been asked to update it.",
                                        ], 200);
                                    break;

                                case "OrderStatusChangedToOrderRejectedAnatomicalChanges":
                                    $res = $this->askForNewFileToDoctor('ios', $pTreatmentPlan, $type);
                                    return response()->json([
                                            'status'  => true,
                                            'message' => "The order was rejected due to anatomical changes detected in the patient’s scan. Doctor has been notified to re-upload the IOS (Intraoral Scan) file.",
                                        ], 200);
                                    break;

                                case "OrderStatusChangedToOrderRejectedAdditionalTeeth":
                                    $res = $this->askForNewFileToDoctor('ios', $pTreatmentPlan, $type);
                                    return response()->json([
                                            'status'  => true,
                                            'message' => "The order was rejected because additional teeth were detected in the scan. Doctor has been informed to upload a new IOS (Intraoral Scan) file.",
                                        ], 200);
                                    break;

                                // No need to show message generating STL files
                                case "OrderStatusChangedToWaitingForFiles":
                                    $this->sendMessageGeneratingFiles($pTreatmentPlan, $type);
                                    return response()->json([
                                        'status'  => true,
                                        'message' => "Your patient’s treatment plan is currently being processed. We’ll notify you once your order is ready.",
                                    ], 200);
                                    break;

                                case "OrderStatusChangedToWaitingForPatientScan":
                                    $this->sendMessageGeneratingFiles($pTreatmentPlan, $type);
                                    return response()->json([
                                        'status'  => true,
                                        'message' => "Your patient’s treatment plan is currently being processed. We’ll notify you once your order is ready.",
                                    ], 200);
                                    break;

                                case "OrderStatusChangedToOrderReview":
                                    $this->sendMessageGeneratingFiles($pTreatmentPlan, $type);
                                    return response()->json([
                                        'status'  => true,
                                        'message' => "Your patient’s treatment plan is currently being processed. We’ll notify you once your order is ready.",
                                    ], 200);
                                    break;

                                case "OrderStatusChangedToWaitingForNewPatientScan":
                                    $this->sendMessageGeneratingFiles($pTreatmentPlan, $type);
                                    return response()->json([
                                        'status'  => true,
                                        'message' => "Your patient’s treatment plan is currently being processed. We’ll notify you once your order is ready.",
                                    ], 200);
                                    break;


                                // Cancel order from our Side
                                case "OrderStatusChangedToOrderCancelled":
                                    $this->orderCancel($pTreatmentPlan, $type);
                                    return response()->json([
                                        'status'  => true,
                                        'message' => "Your order has been cancelled.",
                                    ], 200);
                                    break;

                                case "OrderStatusChangedToOrderRejectedCarriereTreatment":
                                    $this->orderCancel($pTreatmentPlan, $type);
                                    return response()->json([
                                        'status'  => true,
                                        'message' => "Your order was rejected due to Carriere treatment requirements.",
                                    ], 200);
                                    break;

                                case "OrderStatusChangedToOrderRejectedPalatalExpander":
                                    $this->orderCancel($pTreatmentPlan, $type);
                                    return response()->json([
                                        'status'  => true,
                                        'message' => "Your order was rejected due to Palatal Expander treatment requirements.",
                                    ], 200);
                                    break;

                                case "OrderStatusChangedToOrderRejectedBracesTreatment":
                                    $this->orderCancel($pTreatmentPlan, $type);
                                    return response()->json([
                                        'status'  => true,
                                        'message' => "Your order was rejected due to Braces treatment requirements.",
                                    ], 200);
                                    break;

                                case "OrderStatusChangedToOrderRejectedOther":
                                    $this->orderCancel($pTreatmentPlan, $type);
                                    return response()->json([
                                        'status'  => true,
                                        'message' => "Your order was rejected due to other reasons. Please contact support for details.",
                                    ], 200);
                                    break;

                                case "OrderStatusChangedToOrderCompleted":
                                    if ($orderProcess && isset($orderProcess['generated_files']['generated_stl_files']['url']) ) {
                                        $this->orderCompleted($orderProcess, $pTreatmentPlan);
                                        return response()->json([
                                            'status'  => true,
                                            'message' => 'STL files uploaded successfully',
                                        ], 200);
                                    } else {
                                        $details = [
                                            'subject' => 'Webhook Called : STL file(s) not found in order response',
                                            'title' => 'Webhook Called : STL file(s) not found in order response',
                                            'email' => 'wisherw064@gmail.com',
                                            'message' => "Unhandled event type: {$type}",
                                            'data' => json_encode($request->all()),
                                        ];
                                        WeebhookFaildCalledJob::dispatch($details);
                                        return response()->json([
                                            'status'  => false,
                                            'message' => 'STL file(s) not found in order response',
                                        ], 200);
                                    }
                                    break;

                                default:
                                    $details = [
                                        'subject' => 'Webhook Called : Unhandled event type - '.$type,
                                        'title' => 'Webhook Called : Unhandled event type - '.$type,
                                        'email' => 'wisherw064@gmail.com',
                                        'message' => "Unhandled event type: {$type}",
                                        'data' => json_encode($request->all()),
                                    ];
                                    WeebhookFaildCalledJob::dispatch($details);
                                    return response()->json([
                                        'status'  => false,
                                        'message' => "Unhandled event type: {$type}",
                                    ], 200);
                                    break;
                            }
                        }
                        $details = [
                            'subject' => 'Webhook Called: Treatment plan not found',
                            'title' => 'Webhook Called: Treatment plan not found',
                            'email' => 'wisherw064@gmail.com',
                            'message' => 'Treatment plan not found for order ID: ' . $orderId,
                            'data' => json_encode($request->all()),
                        ];
                        WeebhookFaildCalledJob::dispatch($details);
                        return response()->json([
                            'status'  => true,
                            'message' => 'Treatment plan not found',
                        ], 200);
                    }

                    $details = [
                        'subject' => 'Webhook Faild : Invalid orderProcess',
                        'title' => 'Webhook Faild : Invalid orderProcess',
                        'email' => 'wisherw064@gmail.com',
                        'message' => "Webhook Faild : Invalid orderProcess",
                        'data' => json_encode($request->all()),
                    ];
                    WeebhookFaildCalledJob::dispatch($details);
                    return response()->json([
                        'status'  => false,
                        'message' => '',
                    ], 200);
                }
                $details = [
                    'subject' => 'Webhook Faild : Order URL Not Found',
                    'title' => 'Webhook Faild : Order URL Not Found',
                    'email' => 'wisherw064@gmail.com',
                    'message' => "Webhook Faild : Order URL Not Found",
                    'data' => json_encode($request->all()),
                ];
                WeebhookFaildCalledJob::dispatch($details);
                return response()->json([
                    'status'  => false,
                    'message' => '',
                ], 200);
            }


            $details = [
                'subject' => 'Webhook Faild : Order Resource Not Found',
                'title' => 'Webhook Faild : Order Resource Not Found',
                'email' => 'wisherw064@gmail.com',
                'message' => "Webhook Faild : Order Resource Not Found",
                'data' => json_encode($request->all()),
            ];
            WeebhookFaildCalledJob::dispatch($details);
            return response()->json([
                'status'  => false,
                'message' => '',
            ], 200);


        }

        $details = [
            'subject' => 'Webhook Called: Invalid platform',
            'title' => 'Webhook Called: Invalid platform',
            'email' => 'wisherw064@gmail.com',
            'message' => 'Invalid platform',
            'data' => json_encode($request->all()),
        ];
        WeebhookFaildCalledJob::dispatch($details);
        return response()->json([
            'status'  => false,
            'message' => 'Invalid platform',
        ], 200);
    }

    public function askForNewFileToDoctor($fileType = null, $patientDetails, $eventType)
    {
        $fileTypeMessages = [
            'stage' => 'stage file',
            'ios' => 'IOS (Intraoral Scan) file',
            'alignerNumber' => 'aligner number information'
        ];
         $eventReasons = [
            'OrderStatusChangedToWaitingForNewFilesStageFileIncorrect' => 'The uploaded stage file appears to be incorrect.',
            'OrderStatusChangedToWaitingForNewFilesStageFileCorrupted' => 'The uploaded stage file is corrupted and cannot be processed.',
            'OrderStatusChangedToWaitingForNewFilesStageFileUnusable' => 'The uploaded stage file is unusable for the treatment workflow.',

            'OrderStatusChangedToWaitingForNewFilesIOSIncorrect' => 'The uploaded IOS (Intraoral Scan) file appears to be incorrect.',
            'OrderStatusChangedToWaitingForNewFilesIOSCorrupted' => 'The uploaded IOS (Intraoral Scan) file is corrupted and cannot be processed.',
            'OrderStatusChangedToWaitingForNewFilesIOSUnusable' => 'The uploaded IOS (Intraoral Scan) file is unusable for the treatment workflow.',

            'OrderStatusChangedToWaitingForNewFilesAlignerNumberIncorrect' => 'The aligner number information appears to be incorrect.',

            'OrderStatusChangedToOrderRejectedAnatomicalChanges' => 'Due to anatomical changes detected in the patient’s scan, a new IOS (Intraoral Scan) file is required.',
            'OrderStatusChangedToOrderRejectedAdditionalTeeth' => 'Additional teeth were detected in the scan. A new IOS (Intraoral Scan) file is required.',
        ];

        $fileTypeText = $fileTypeMessages[$fileType] ?? 'required file';
        $reasonMessage  = $eventReasons[$eventType] ?? 'required file';

        $details = [
            'subject' => 'Action Required: New ' . ucfirst($fileTypeText) . ' Needed',
            'title' => 'Action Required: New ' . ucfirst($fileTypeText) . ' Needed',
            'doctor_email' => $patientDetails->doctor_email,
            'doctor_name' => $patientDetails->doctor_first_name. ' ' . $patientDetails->doctor_last_name,
            'patient_name' => $patientDetails->first_name. ' ' .$patientDetails->last_name,
            'message' => "{$reasonMessage} Please upload a new {$fileTypeText} to continue the treatment process.",
            'patient_id' => $patientDetails->patinetId,
            'pTreatmentPlanId' => $patientDetails->id,
        ];
        // WeebhookFaildCalledJob::dispatch($details);
        AskForNewFileToDoctorJob::dispatch($details);
        DB::table('p_treatment_plans')
        ->where('id', $patientDetails->id)
        ->where('dm_order_id', $patientDetails->dm_order_id)
        ->update([
            "dm_order_status" => $eventType,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Doctor notification sent for new ' . $fileTypeText . ' requirement',
        ], 200);
    }

    public function sendMessageGeneratingFiles($patientDetails, $eventType)
    {
        $details = [
            'subject' => ' DM Order Confirmation: DM successfully recieved your Smart STLs Order.',
            'title' => ' DM Order Confirmation: DM successfully recieved your Smart STLs Order.',
            'doctor_email' => $patientDetails->doctor_email,
            'doctor_name' => $patientDetails->doctor_first_name . ' ' . $patientDetails->doctor_last_name,
            'patient_name' => $patientDetails->first_name . ' ' . $patientDetails->last_name,
            'message' => "Your Smart STLs order for your Patient ". $patientDetails->first_name . ' ' . $patientDetails->last_name ." is currently being processed. We’ll notify you once the SMART STLs are ready.",
            'patient_id' => $patientDetails->patinetId ?? $patientDetails->patient_id ?? null,
            'pTreatmentPlanId' => $patientDetails->id,
        ];

        // Dispatch job to notify the doctor
        SendMessageGeneratingFilesJob::dispatch($details);
        DB::table('p_treatment_plans')
        ->where('id', $patientDetails->id)
        ->where('dm_order_id', $patientDetails->dm_order_id)
        ->update([
            "dm_order_status" => $eventType,
        ]);

    }

    public function orderCancel($patientDetails, $eventType)
    {
        // Optional: descriptive reasons for logging / notification
        $eventReasons = [
            'OrderStatusChangedToOrderCancelled' => 'Order has been cancelled by the system.',
            'OrderStatusChangedToOrderRejectedCarriereTreatment' => 'Order rejected due to Carriere treatment requirements.',
            'OrderStatusChangedToOrderRejectedPalatalExpander' => 'Order rejected due to Palatal Expander treatment requirements.',
            'OrderStatusChangedToOrderRejectedBracesTreatment' => 'Order rejected due to Braces treatment requirements.',
            'OrderStatusChangedToOrderRejectedOther' => 'Order rejected due to other reasons.',
        ];

        $reasonMessage = $eventReasons[$eventType] ?? 'Order has been cancelled or rejected.';

        // Optional: dispatch notification to doctor
        $details = [
            'subject' => 'Order Cancelled / Rejected For : '. $patientDetails->first_name . ' ' . $patientDetails->last_name,
            'title' => 'Order Cancelled / Rejected For : '. $patientDetails->first_name . ' ' . $patientDetails->last_name,
            'doctor_email' => $patientDetails->doctor_email,
            'doctor_name' => $patientDetails->doctor_first_name . ' ' . $patientDetails->doctor_last_name,
            'patient_name' => $patientDetails->first_name . ' ' . $patientDetails->last_name,
            'message' => $reasonMessage.'Kindly reorder if you wish to proceed with the Dental Monitoring STL files.',
            'patient_id' => $patientDetails->patient_id ?? $patientDetails->patinetId ?? null,
            'pTreatmentPlanId' => $patientDetails->id,
        ];

        // Notify doctor if needed
        OrderCanceledJob::dispatch($details);

        // Update order status in DB
        DB::table('p_treatment_plans')
            ->where('id', $patientDetails->id)
            ->where('dm_order_id', $patientDetails->dm_order_id)
            ->update([
                "dm_order_status" => $eventType,
                "dm_order_details" => null,
                "dm_order_id" => null,
                "dm_order_completed" => '0',
            ]);
    }

    public function orderCompleted($orderDetails, $patientDetails){
        $fatchAndStoreSTLFiles = $this->fatchAndStoreSTLFiles($orderDetails['generated_files']['generated_stl_files']['url']);
        if($fatchAndStoreSTLFiles && $fatchAndStoreSTLFiles['status'] === true){
            $details = [
                'patientDetails' => $patientDetails,
                'fatchAndStoreSTLFiles' => $fatchAndStoreSTLFiles,
            ];
            // $this->handleEv($details);

            OrderCompletedJob::dispatch($details);
            return 'true';
        } else {
            return 'fatchAndStoreSTLFilesFaild';
        }
    }

    public function getASmartSTLOrder($orderUrl)
    {
        if (!$orderUrl) {
            return [
                'status'  => false,
                'message' => 'Order URL missing',
            ];
        }

        try {
            $response = Http::timeout(120)
                ->withHeaders([
                    'x-dm-api-key' => config('webhook.x-dm-api-key'),
                    'Accept'       => 'application/json',
                ])
                ->get($orderUrl);

            if ($response->failed()) {
                return [
                    'status'  => false,
                    'message' => 'Failed to fetch Smart STL order details',
                ];
            }

            return $response->json();

        } catch (\Exception $e) {
            Log::error('DM API Exception', ['message' => $e->getMessage()]);

            return [
                'status'  => false,
                'message' => 'Exception: ' . $e->getMessage(),
            ];
        }
    }

    public function fatchAndStoreSTLFiles($stlFilesUrl)
    {
        try {
            $response = Http::timeout(120)
                ->withHeaders([
                    'x-dm-api-key' => config('webhook.x-dm-api-key'),
                    'Accept'       => 'application/zip',
                ])
                ->get($stlFilesUrl);

            if ($response->failed()) {
                return [
                    'status'  => false,
                    'message' => 'Failed to download STL ZIP file',
                ];
            }

            // 🔑 File content (binary)
            $fileContent = $response->body();

            // 📂 Storage path for ZIP + extracted STL
            $storagePath = storage_path('app/stl-files');
            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0777, true);
            }

            // 📌 ZIP file name
            $zipFileName = 'stl_' . time() . '.zip';
            $zipFilePath = $storagePath . '/' . $zipFileName;

            // Save ZIP file
            File::put($zipFilePath, $fileContent);

            // 📦 Extract ZIP
            $zip = new \ZipArchive;
            $extractPath = $storagePath . '/unzipped_' . time();

            if ($zip->open($zipFilePath) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();
            } else {
                return [
                    'status'  => false,
                    'message' => 'Failed to unzip STL ZIP file',
                ];
            }

            // 🔎 Find STL files
            $files = File::allFiles($extractPath);
            $lowerArchFile = null;
            $upperArchFile = null;

            foreach ($files as $file) {
                $fileName = $file->getFilename();

                if (str_ends_with($fileName, '_md.stl')) {
                    $lowerArchFile = $file->getRealPath();
                }

                if (str_ends_with($fileName, '_mx.stl')) {
                    $upperArchFile = $file->getRealPath();
                }
            }

            return [
                'status'   => true,
                'message'  => 'STL ZIP file downloaded and extracted successfully',
                'zip_file' => $zipFilePath,
                'extract_path' => $extractPath,
                'lower_arch' => $lowerArchFile,
                'upper_arch' => $upperArchFile,
            ];

        } catch (\Exception $e) {
            Log::error('STL File Download/Unzip Error', ['message' => $e->getMessage()]);

            return [
                'status'  => false,
                'message' => 'Exception: ' . $e->getMessage(),
            ];
        }
    }

    public function uploadStlFilesOnserver($patientId, $treatmentPlanId, $upperArch, $lowerArch)
    {
        try {

            // Create patient directory
            $directory = $this->mkDr($patientId);
            if (!$directory || !is_dir($directory)) {
                return [
                    'status' => 'error',
                    'message' => 'Failed to create patient directory',
                ];
            }

            $uploadedFiles = [];
            $errors = [];

            // Upload Upper Arch STL
            if ($upperArch && file_exists($upperArch)) {
                $upperFileName = 'upper_arch_' . time() . '_' . uniqid() . '.stl';
                $upperFilePath = $directory . DIRECTORY_SEPARATOR . $upperFileName;

                if (copy($upperArch, $upperFilePath)) {
                    $uploadedFiles['upper_arch'] = $upperFileName;
                    Log::info("Upper arch STL uploaded successfully", [
                        'patient_id' => $patientId,
                        'treatment_plan_id' => $treatmentPlanId,
                        'file' => $upperFileName
                    ]);
                } else {
                    $errors[] = 'Failed to upload upper arch STL file';
                }
            } else {
                $uploadedFiles['upper_arch'] = $plan->fl_upper_arch ?? null;
            }

            // Upload Lower Arch STL
            if ($lowerArch && file_exists($lowerArch)) {
                $lowerFileName = 'lower_arch_' . time() . '_' . uniqid() . '.stl';
                $lowerFilePath = $directory . DIRECTORY_SEPARATOR . $lowerFileName;

                if (copy($lowerArch, $lowerFilePath)) {
                    $uploadedFiles['lower_arch'] = $lowerFileName;
                    Log::info("Lower arch STL uploaded successfully", [
                        'patient_id' => $patientId,
                        'treatment_plan_id' => $treatmentPlanId,
                        'file' => $lowerFileName
                    ]);
                } else {
                    $errors[] = 'Failed to upload lower arch STL file';
                }
            } else {
                $uploadedFiles['lower_arch'] = $plan->fl_lower_arch ?? null;
            }

            // Check if there were any upload errors
            if (!empty($errors)) {
                return [
                    'status' => 'error',
                    'message' => implode(', ', $errors),
                    'files' => $uploadedFiles,
                ];
            }

            // Update database columns
            $updateResult = DB::table('p_treatment_plans')
                ->where('id', $treatmentPlanId)
                ->update([
                    'fl_upper_arch' => $uploadedFiles['upper_arch'],
                    'fl_lower_arch' => $uploadedFiles['lower_arch'],
                    'dm_order_completed' => '1',
                    'dm_order_status' => 'OrderStatusChangedToOrderCompleted',
                    'dm_order_id' => null,
                    // 'dm_order_details' => null,
                    'updated_at' => now(),
                ]);

            if ($updateResult) {
                Log::info("Treatment plan updated with STL files", [
                    'patient_id' => $patientId,
                    'treatment_plan_id' => $treatmentPlanId,
                    'files' => $uploadedFiles
                ]);

                return [
                    'status' => 'success',
                    'message' => 'STL files uploaded and database updated successfully',
                    'files' => $uploadedFiles,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Failed to update database with file information',
                    'files' => $uploadedFiles,
                ];
            }

        } catch (\Exception $e) {
            Log::error('Error uploading STL files', [
                'patient_id' => $patientId,
                'treatment_plan_id' => $treatmentPlanId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'status' => 'error',
                'message' => 'An error occurred while uploading STL files: ' . $e->getMessage(),
            ];
        }
    }

    protected function mkDr($patient_id)
    {
        $directory = storage_path('/PatientFiles/Patient' . $patient_id);

        if (!File::exists($directory)) {
            $old_umask = umask(0);
            File::makeDirectory($directory, 0777, true, true);
            $directory = storage_path('/PatientFiles/Patient' . $patient_id);
            umask($old_umask);
        }
        return $directory;
    }

    public function handleEv($details){
        $patientDetails = $details['patientDetails'];
        $fatchAndStoreSTLFiles = $details['fatchAndStoreSTLFiles'];
        $uploadStlFilesOnserver = $this->uploadStlFilesOnserver( $patientDetails->patinetId, $patientDetails->id, $fatchAndStoreSTLFiles['upper_arch'], $fatchAndStoreSTLFiles['lower_arch']);

        if($uploadStlFilesOnserver['status'] === 'success'){

            // ✅ Cleanup temporary files (ZIP + extracted)
            if (!empty($fatchAndStoreSTLFiles['zip_file']) && File::exists($fatchAndStoreSTLFiles['zip_file'])) {
                File::delete($fatchAndStoreSTLFiles['zip_file']);
            }

            if (!empty($fatchAndStoreSTLFiles['extract_path']) && File::isDirectory($fatchAndStoreSTLFiles['extract_path'])) {
                File::deleteDirectory($fatchAndStoreSTLFiles['extract_path']);
            }

            $mailDetails = [
                'subject' => 'Action Required: SMART STL files are ready!',
                'title' => 'Action Required: SMART STL files are ready!',
                'doctor_email' => $patientDetails->doctor_email,
                'doctor_name' => $patientDetails->doctor_first_name . ' ' . $patientDetails->doctor_last_name,
                'patient_name' => $patientDetails->first_name . ' ' . $patientDetails->last_name,
                'patient_id' => $patientDetails->patient_id ?? $patientDetails->patinetId ?? null,
                'pTreatmentPlanId' => $patientDetails->id,
            ];

            Notification::route('mail', $patientDetails->doctor_email)
                    ->notify(new WeebhookSuccess($mailDetails));
            // WeebhookSuccessJob::dispatch($details);

            return response()->json([
                'status'  => true,
                'message' => $uploadStlFilesOnserver['message'] ?? 'STL files uploaded successfully',
                'files' => $uploadStlFilesOnserver['files'] ?? null,
            ], 200);
        } else {
            // Log the error and return failure response
            Log::error('Failed to upload STL files', [
                'patient_id' => $patientDetails['patinetId'],
                'treatment_plan_id' => $patientDetails['id'],
                'error' => $uploadStlFilesOnserver['message'] ?? 'Unknown error'
            ]);
            $details = [
                'subject' => 'Webhook Called: Failed to upload STL files',
                'title' => 'Webhook Called: Failed to upload STL files',
                'email' => 'wisherw064@gmail.com',
                'message' => $uploadStlFilesOnserver['message'] ?? 'Failed to upload STL files',
                'data' => json_encode([]),
            ];
            WeebhookFaildCalledJob::dispatch($details);
            return response()->json([
                'status'  => false,
                'message' => $uploadStlFilesOnserver['message'] ?? 'Failed to upload STL files',
            ], 200);
        }
    }
}
