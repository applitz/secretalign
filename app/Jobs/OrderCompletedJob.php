<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WeebhookSuccess;
class OrderCompletedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $patientDetails = $this->details['patientDetails'];
        $fatchAndStoreSTLFiles = $this->details['fatchAndStoreSTLFiles'];
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
                'subject' => 'Action Required: STL files uploaded - please check and process further treatment for patient '. $patientDetails->first_name . ' ' . $patientDetails->last_name,
                'title' => 'Action Required: STL files uploaded - please check and process further treatment for patient '. $patientDetails->first_name . ' ' . $patientDetails->last_name,
                'doctor_email' => $patientDetails->doctor_email,
                'doctor_name' => $patientDetails->doctor_first_name . ' ' . $patientDetails->doctor_last_name,
                'patient_name' => $patientDetails->first_name . ' ' . $patientDetails->last_name,
                'patient_id' => $patientDetails->patient_id ?? $patientDetails->patinetId ?? null,
                'pTreatmentPlanId' => $patientDetails->id,
            ];

            Notification::route('mail', $patientDetails->doctor_email)
                    ->notify(new WeebhookSuccess($mailDetails));
            WeebhookSuccessJob::dispatch($mailDetails);

            return response()->json([
                'status'  => true,
                'message' => $uploadStlFilesOnserver['message'] ?? 'STL files uploaded successfully',
                'files' => $uploadStlFilesOnserver['files'] ?? null,
            ], 200);
        } else {
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

    public function uploadStlFilesOnserver($patientId, $treatmentPlanId, $upperArch, $lowerArch)
    {
        try {
            // Validate input parameters
            if (!$patientId || !$treatmentPlanId) {
                return [
                    'status' => 'error',
                    'message' => 'Patient ID and Treatment Plan ID are required',
                ];
            }

            // Check if treatment plan exists
            $plan = DB::table('p_treatment_plans')
                ->where('patient_id', $patientId)
                ->where('id', $treatmentPlanId)
                ->first();

            if (!$plan) {
                return [
                    'status' => 'error',
                    'message' => 'Treatment plan not found',
                ];
            }

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
}
