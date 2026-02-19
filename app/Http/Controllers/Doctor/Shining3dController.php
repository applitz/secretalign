<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Shining3Details;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class Shining3dController extends Controller
{
    protected string $baseUrl;

    public function setRegion(string $region): self
    {
        $this->baseUrl = match ($region) {
            'frankfurt' => 'https://ffapi.shining3d.com',
            'hz' => 'https://hzapi.shining3d.com',
            'ru' => 'https://ruapi.shining3d.com',
            'silicon' => 'https://sapi.shining3d.com',
            'tokyo' => 'https://tkapi.shining3d.com',
            default => throw new \InvalidArgumentException('Invalid region'),
        };
        return $this;
    }
    public function getOrderList(Request $request)
    {
        $stardDate = date('Y-m-d', strtotime($request->input('start_date')));
        $endDate = date('Y-m-d', strtotime($request->input('end_date')));
        $response = Http::withHeaders([
            'X-Auth-Token' => $request->input('authToken'),
            'X-Auth-AppKey' => config('shining3d.shining3d_app_key'),
            'X-Auth-AppID' => config('shining3d.shining3d_app_id'),
        ])->get($request->input('region') . '/sdk/dental/order/list', [
            'orgType' => $request->input('orgType'),
            'doctorID' => $request->input('doctorId'),
            'orgCode' => $request->input('orgCode'),
            'page' => 1,
            'pageSize' => 10,
            'startOn' => $stardDate,
            'endOn' => $endDate,
        ]);
        return $response->json();
    }


    protected function getValidAuthToken(string $region): string
    {
        $detail = Shining3Details::where('node', $region)->first();

        if ($detail?->auth_token) {
            return $detail->auth_token;
        }
        $csrf = $this->getCsrfToken($region);
        $auth = $this->connect($region, $csrf);

        return $auth;
    }


    protected function getCsrfToken(string $region): string
    {
        $detail = Shining3Details::where('node', $region)->first();
        if ($detail?->auth_csrf) {
            return $detail->auth_csrf;
        }


        $response = Http::withHeaders([
            'X-Auth-AppID' => config('shining3d.shining3d_app_id'),
        ])->get($this->baseUrl . '/sdk/auth/dynamicEncodeToken')->json();


        Shining3Details::updateOrCreate(
            ['node' => $region],
            ['auth_csrf' => $response['result'], 'auth_token' => null]
        );


        return $response['result'];
    }


    protected function connect(string $region, string $csrfToken): string
    {
        $url = $this->baseUrl . '/sdk/auth/connect?publicKey=' . config('shining3d.shining3d_public_key');
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


        Shining3Details::updateOrCreate(
        ['node' => $region],
        ['auth_token' => $response['result']]
        );


        return $response['result'];
    }

    public function encryptAES($data)
    {
        $key = config('shining3d.shining3d_app_key');
        $iv  = substr($key, 0, 16);

        $encrypted = openssl_encrypt(
            json_encode($data),
            'AES-128-CBC',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        return base64_encode($encrypted);
    }

    public function dataDownload(Request $request)
    {
        $csrfToken  = getDynamicEncryptionToken($request->input('domainUrl'));
        $patientId = $request->input('patientId');
        $treatmentPlanId = $request->input('treatmentPlanId');

        if($csrfToken['status'] == 'success') {
            $response = Http::withHeaders([
                'X-Auth-Token'     => $request->input('authToken'),
                'X-Auth-AppKey'    => config('shining3d.shining3d_app_key'),
                'X-Auth-AppID'     => config('shining3d.shining3d_app_id'),
                'isCsrf'           => 'true',
                'X-Encrypt-AES'    => 'true',
                'X-Auth-CSRF'      => $csrfToken['result'] ,
                'Content-Type'     => 'application/json',
                'Content-Type'     => 'application/json',
            ])->post($request->input('domainUrl') . '/sdk/dental/order/dataDownload', [
                'orgCode'    => $request->input('orgCode'),
                'id'         => $request->input('orderID'),
                'attachType' => 'full_stl',
            ]);

            // Raw response
            $data = $response->body();

            // If response is JSON
            $json = $response->json();
            $domainUrl = 'https://s3.eu-central-1.amazonaws.com/awsdown.dental3dcloud.com/dentalService/471557c7-bcbc-5d5d-90fa-598b43228317/da238fd1-2ce1-5cde-ba31-40b017569779/full/stl/1e42f82c7f5eef03323211eb2416c4ac?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Checksum-Mode=ENABLED&X-Amz-Credential=AKIA2QJ2WUEBGOJBNOWF%2F20260219%2Feu-central-1%2Fs3%2Faws4_request&X-Amz-Date=20260219T105614Z&X-Amz-Expires=86400&X-Amz-SignedHeaders=host&x-id=GetObject&X-Amz-Signature=bd1af4d4a521855fcd6d010165900ee3db66f9084bba67125b94cf422b0d138c';
            $dataUpload = $this->dataUpload($domainUrl, $patientId, $treatmentPlanId);
            return $json;
        }
        return response()->json(['status' => 'error', 'message' => 'Failed to get CSRF token'], 500);
    }

    public function dataDownloadAndUpload(Request $request)
    {
        $patientId = '1486';
        $domainUrl = 'https://s3.eu-central-1.amazonaws.com/awsdown.dental3dcloud.com/dentalService/471557c7-bcbc-5d5d-90fa-598b43228317/da238fd1-2ce1-5cde-ba31-40b017569779/full/stl/1e42f82c7f5eef03323211eb2416c4ac?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Checksum-Mode=ENABLED&X-Amz-Credential=AKIA2QJ2WUEBGOJBNOWF%2F20260219%2Feu-central-1%2Fs3%2Faws4_request&X-Amz-Date=20260219T105614Z&X-Amz-Expires=86400&X-Amz-SignedHeaders=host&x-id=GetObject&X-Amz-Signature=bd1af4d4a521855fcd6d010165900ee3db66f9084bba67125b94cf422b0d138c';
        $treatmentPlanId = 1821;
        $dataUpload = $this->dataUpload($domainUrl, $patientId, $treatmentPlanId);
        dd($dataUpload);
    }

    public function dataUpload($link, $patientId, $treatmentPlanId)
    {
        try {


            // 📂 Storage path for ZIP + extracted STL
            $storagePath = storage_path('app/stl-files/' . $patientId . '/');
            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0777, true);
            }

            // 2️⃣ Download ZIP file
            $zipPath = $storagePath . 'stl_' . time() . '.zip';

            $response = Http::timeout(300)->get($link);

            if (!$response->successful()) {
                return "Failed to download ZIP file";
            }

            file_put_contents($zipPath, $response->body());

            // 3️⃣ Unzip file
            $zip = new ZipArchive;

            if ($zip->open($zipPath) === TRUE) {
                $zip->extractTo($storagePath);
                $zip->close();
            } else {
                return "Failed to unzip file";
            }

            $files = File::allFiles($storagePath);
            $lowerArchFile = null;
            $upperArchFile = null;

            foreach ($files as $file) {
                $fileName = $file->getFilename();

                if (str_ends_with($fileName, 'LowerJaw.stl')) {
                    $lowerArchFile = $file->getRealPath();
                }

                if (str_ends_with($fileName, 'UpperJaw.stl')) {
                    $upperArchFile = $file->getRealPath();
                }
            }
            $uploadStlFilesOnserver = $this->uploadStlFilesOnserver($patientId, $treatmentPlanId, $upperArchFile, $lowerArchFile);
            dd($uploadStlFilesOnserver);

        } catch (\Exception $e) {
            return $e->getMessage();
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
}
