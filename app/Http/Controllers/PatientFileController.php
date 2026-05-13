<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;

class PatientFileController extends Controller
{
    public $hashids;
    public function __construct()
    {
        $this->middleware([
            'auth',
            'auth.patient.requests',
        ]);
        $this->hashids = new Hashids();
        View::share("hashids", $this->hashids);
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
    private function MeditLinkGetCase($Uuid)
    {
         $token = DB::table('medit_links')
                ->where('user_id', Auth::user()->id)
                ->get();
        // solved by Tapas Web Solution x dotprogrammers
        $curl = curl_init();

        curl_setopt_array($curl, array(
        //  CURLOPT_URL => 'https://'.env('MEDIT_LINK_OPENAPI_SERVER').'openapi-resources.meditlink.com/v1/cases/'.$Uuid,
             CURLOPT_URL => 'https://openapi-resources.meditlink.com/v1/cases/'.$Uuid,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
          //  'Host: '.env('MEDIT_LINK_OPENAPI_SERVER').'openapi-resources.meditlink.com',
            'Host: openapi-resources.meditlink.com',
            'Content-Type: application/json',
            'Authorization: Bearer '.$token[0]->medit_link_access_token,
            'x-meditlink-client-id: '.env('MEDIT_LINK_CLIENT_ID'),
            'x-meditlink-group-uuid: '.$token[0]->medit_link_group_uuid
          ),
        ));

        $response = curl_exec($curl);


        curl_close($curl);
        $response = json_decode($response);

        Log::info(json_encode($response));
        $upper_arch_uuid = null;
        $lower_arch_uuid = null;
        $patient_name = null;
        $patient_code = null;
        if(@$response->uuid) {
           // dd($response->patient->code);
            // $patient_name = $response->patient->name;
            // $patient_code = $response->patient->code;

            if(count($response->files) > 0) {
                foreach ($response->files as $file) {
                    Log::info($file->name);
                    if($file->name == "Gallistl_Barbara-LowerJawScan.stl.general.meditMesh") {
                        $lower_arch_uuid = $file->uuid;
                    }
                    if($file->name == "Gallistl_Barbara-UpperJawScan.stl.general.meditMesh") {
                        $upper_arch_uuid = $file->uuid;
                    }
                }
            }
        }
        return (object) compact("upper_arch_uuid", "lower_arch_uuid","patient_name","patient_code");
    }
    private function MeditLinkGetFile($Uuid)
    {
        // solved by Tapas Web Solution x dotprogrammers
                 $token = DB::table('medit_links')
                ->where('user_id', Auth::user()->id)
                ->get();
        $curl = curl_init();

        curl_setopt_array($curl, array(
          //  CURLOPT_URL => 'https://'.env('MEDIT_LINK_OPENAPI_SERVER').'openapi-resources.meditlink.com/v1/files/'.$Uuid.'?type=stl',
          CURLOPT_URL => 'https://openapi-resources.meditlink.com/v1/files/'.$Uuid.'?type=stl',
          CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Host: openapi-resources.meditlink.com',
                'Authorization: Bearer '.$token[0]->medit_link_access_token,
                'x-meditlink-client-id: '.env('MEDIT_LINK_CLIENT_ID'),
                'x-meditlink-group-uuid: '.$token[0]->medit_link_group_uuid
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
       // dd($response);

        $file = null;
        if(@$response->uuid) {
            $file = $response;
        }
        return $file;
    }
    private function MeditLinkDownloadAndExtract7Zip($patient_id, $_file)
    {
        $url = $_file->url;
        $itemName = $_file->items[0]->name;
        $downloadFileName = $_file->downloadFileName;
        $directory = $this->mkDr($patient_id);

        $downloadFilePath = $directory . '/' . $downloadFileName;


        $filename = time() . rand(1, 100) . '.stl';
        // Check if file with same name already exists
        if (File::exists($directory . '/' . $filename)) {
            $count = 2;
            $file_parts = pathinfo($filename);

            // Loop until a unique filename is found
            while (File::exists($directory . '/' . $file_parts['filename'] . '(' . $count . ').' . $file_parts['extension'])) {
                $count++;
            }

            // Rename file with original name and count number
            $filename = $file_parts['filename'] . '(' . $count . ').' .  "stl";
        }

        // Download the file using cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_FILE, fopen($downloadFilePath, 'w+'));
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            dd("cURL error ({$error_msg})");
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($response && $httpCode === 200) {

            try {
                $archive = new \App\Http\Services\Archive7zService($downloadFilePath);
                if (!$archive->isValid()) {
                    $filename = null;
                }
                $archive->setOutputDirectory($directory);

                $solidMode = new \Archive7z\SolidMode();
                $solidMode->setMode(\Archive7z\SolidMode::OFF);
                $archive->setSolidMode($solidMode);
                $archive->renameEntry($itemName, $filename);
                $archive->extract();

                while (!File::exists($directory . '/'. $filename)) {
                    sleep(1);
                }
                if (file_exists($downloadFilePath)) {
                    unlink($downloadFilePath);
                }
            } catch (\Exception $e) {
                $filename = null;
            }

        } else {
            $filename = null;
        }
        return $filename;
    }
    private function MeditLinkSaveSTL($patient_id, $treatment_plan_id, $column, $file_uuid,$patient_name,$patient_code)
    {
        ini_set('max_execution_time', 6000); // 6000 seconds = 100 minutes
        // solved by Tapas Web Solution x dotprogrammers

        $_file = $this->MeditLinkGetFile($file_uuid);
       // $_info = $this->MeditLinkGetCase($file_uuid);
        // dd($patient_name,$patient_code );
         $patient_case= DB::table('p_treatment_plans')->first();
        // dd($patient_case);
        $name_parts = explode(" ", $patient_name);
        // $patient = DB::table('patients')
        // ->where('id', $patient_case->patient_id)
        // ->update([
        //     'first_name'=> $name_parts[0],
        //     'last_name' => $name_parts[1],
        //     'patientId' => $patient_code,
        // ]);

       // dd($patient);
        if($_file != null) {
            $filename = $this->MeditLinkDownloadAndExtract7Zip($patient_id, $_file);
            if($filename != null) {
                DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
                    $column => $filename . ".stl",
                ]);
            }
            return $filename;
        }
        return null;
    }
    public function MeditLinkDownloadSTL(Request $request)
    {
        $patient_id = $request->post('patient_id');
        $treatment_plan_id = $request->post('treatment_plan_id');
        $caseUuid = $request->post('uuid');
        $data = [];
        $case = $this->MeditLinkGetCase($caseUuid);

        if($case->upper_arch_uuid) {
            $data['upper'] = $this->MeditLinkSaveSTL($patient_id, $treatment_plan_id, 'fl_upper_arch', $case->upper_arch_uuid,$case->patient_name,$case->patient_code);
        }
        if($case->lower_arch_uuid) {
            $data['lower'] = $this->MeditLinkSaveSTL($patient_id, $treatment_plan_id, 'fl_lower_arch', $case->lower_arch_uuid,$case->patient_name,$case->patient_code);
        }
                 $name_parts = explode(" ", $case->patient_name);
        // $data['first_name']=$name_parts[0];
        // $data['last_name']=$name_parts[0];

          $data['patient_code']=$case->patient_code;
          Log::info("data");
          Log::info($data);
        return response()->json($data);
    }
    private function ThreeShapeSaveSTL($patient_id, $treatment_plan_id, $column, $caseId, $hash)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://eumetadata.3shapecommunicate.com/api/cases/'.$caseId.'/attachments/'.$hash,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.Auth::user()->three_shape_access_token,
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Check if the request was successful (HTTP status code 200)
        if ($httpCode == 200) {
            $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

            // Check if the content type is "application/octet-stream"
            if ($contentType == 'application/stl') {
                $directory = $this->mkDr($patient_id);
                $filename = time() . rand(1, 100);
                // Check if file with same name already exists
                if (File::exists($directory . '/' . $filename)) {
                    $count = 2;
                    $file_parts = pathinfo($filename);

                    // Loop until a unique filename is found
                    while (File::exists($directory . '/' . $file_parts['filename'] . '(' . $count . ').' . $file_parts['extension'])) {
                        $count++;
                    }

                    // Rename file with original name and count number
                    $filename = $file_parts['filename'] . '(' . $count . ').' .  "stl";
                }


                $filePath = $directory . "/" . $filename . ".stl";
                $fileHandle = fopen($filePath, 'wb');
                fwrite($fileHandle, $response);
                fclose($fileHandle);
                DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
                    $column => $filename . ".stl",
                ]);
                return  $filename.".stl";
            }
        }
        return null;
    }

    public function ThreeShapeDownloadSTL(Request $request)
    {
        $patient_id = $request->post('patient_id');
        $treatment_plan_id = $request->post('treatment_plan_id');
        $caseId = $request->post('case_id');
        $hash_upper = @$request->post('hash_upper');
        $hash_lower = @$request->post('hash_lower');
        $data = [];
        if(!empty($hash_upper)) {
            $data["upper"] = $this->ThreeShapeSaveSTL($patient_id, $treatment_plan_id, "fl_upper_arch", $caseId, $hash_upper);
        }
        if(!empty($hash_lower)) {
            $data["lower"] = $this->ThreeShapeSaveSTL($patient_id, $treatment_plan_id, "fl_lower_arch", $caseId, $hash_lower);
        }
        return response()->json($data);
    }



    public function file_upload(Request $request, $patient_id, $treatment_plan_id)
    {
        if (DB::table('p_treatment_plans')->where('patient_id', $patient_id)->where('id', $treatment_plan_id)->exists()) {
            $file = $request->file('file'.$request->get('key'));
            $attachment = $file->getClientOriginalName();
            $filename = $attachment;
            $filename = str_replace(' ', '-',$attachment);

            $directory = $this->mkDr($patient_id);

            $fileExt = explode('.', $attachment);
            $fileActualExt = strtolower(end($fileExt));

            // Check if file with same name already exists
            if (File::exists($directory . '/' . $filename)) {
                $count = 2;
                $file_parts = pathinfo($filename);

                // Loop until a unique filename is found
                while (File::exists($directory . '/' . $file_parts['filename'] . '(' . $count . ').' . $file_parts['extension'])) {
                    $count++;
                }

                // Rename file with original name and count number
                $filename = $file_parts['filename'] . '(' . $count . ').' .  $fileActualExt;
            }


            $file->move($directory, $filename);

            $column = '';
            if ($request->get('key') == 1) {
                $column = "fl_upper_arch";
            }
            if ($request->get('key') == 2) {
                $column = "fl_lower_arch";
            }
            if ($request->get('key') == 3) {
                $column = "fl_front";
            }
            if ($request->get('key') == 4) {
                $column = "fl_smile";
            }
            if ($request->get('key') == 5) {
                $column = "fl_profile";
            }
            if ($request->get('key') == 6) {
                $column = "fl_frontal";
            }
            if ($request->get('key') == 7) {
                $column = "fl_right_buccal";
            }
            if ($request->get('key') == 8) {
                $column = "fl_left_buccal";
            }
            if ($request->get('key') == 9) {
                $column = "fl_upper_occlusal";
            }
            if ($request->get('key') == 10) {
                $column = "fl_lower_occlusal";
            }
            if ($request->get('key') == 11) {
                $column = "fl_panorex";
            }
            if ($request->get('key') == 12) {
                $column = "fl_lateral_ceph";
            }
            if ($request->get('key') == 13) {
                $column = "fl_general_upload";
            }
            if ($request->get('key') == 14) {
                $column = "fl_posterior_bite_turbos";
            }
            if ($request->get('key') == 15) {
                $column = "fl_anterior_bite_turbos";
            }
            if ($request->get('key') == 16) {
                $column = "fl_bite_keeper";
            }
            if ($request->get('key') == 17) {
                $column = "fl_notes";
            }

            if ($request->get('key') == 18) {
                $column = "optional_fl_upper_arch";
            }

            if ($request->get('key') == 19) {
                $column = "optional_fl_lower_arch";
            }


            if ($column != '') {
                DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
                    $column => $filename,
                ]);
            }

            return response()->json([
                "status" => "success",
                "fileName" => $filename,
            ]);
        }
        return response()->json([
            "status" => "error",
        ]);
    }

    public function file_load(Request $request, $patient_id)
    {

        $directory = $this->mkDr($patient_id) . '/';

        $request->header('Access-Control-Allow-Origin: *');

        // Allow the following methods to access this file
        $request->header('Access-Control-Allow-Methods: OPTIONS, GET, DELETE, POST, HEAD, PATCH');

        // Allow the following headers in preflight
        $request->header('Access-Control-Allow-Headers: content-type, upload-length, upload-offset, upload-name');

        // Allow the following headers in response
        $request->header('Access-Control-Expose-Headers: upload-offset');

        // Load our configuration for this server




        $uniqueFileID = $_GET["key"];

        $imagePointer = $directory .  $uniqueFileID;



        $imageName = $uniqueFileID;






        // if imageName was found in the DB, get file with imageName and return file object or blob
        $imagePointer = $directory . $uniqueFileID;



        $fileObject = null;

        if ($imageName != '' && file_exists($imagePointer)) {

            $fileObject = file_get_contents($imagePointer);
        }



        // trigger load local image
        $loadImageResultArr = [$fileBlob, $imageName] = [$fileObject, $imageName];
        if ($fileBlob) {
            $imagePointer = $directory .  $imageName;
            $fileContextType = mime_content_type($imagePointer);
            $fileSize = filesize($imagePointer);

            $handle = fopen($imagePointer, 'r');
            if (!$handle) return false;
            $content = fread($handle, filesize($imagePointer));


            $response = Response::make($content);
            $response->header('Access-Control-Expose-Headers', 'Content-Disposition, Content-Length, X-Content-Transfer-Id');
            $response->header('Content-Type', $fileContextType);
            $response->header('Content-Length', $fileSize);
            $response->header('Content-Disposition', "inline; filename=$imageName");


            return $response;
        } else {
            http_response_code(500);
        }
    }
    public function file_revert(Request $request, $patient_id, $treatment_plan_id)
    {
        $plan = DB::table('p_treatment_plans')->where('patient_id', $patient_id)->where('id', $treatment_plan_id)->first();
        if ($plan) {
            $directory = $this->mkDr($patient_id) . '/';
            $column = '';
            if ($request->post('key') == 1) {
                $column = "fl_upper_arch";
                unlink($directory . $plan->fl_upper_arch);
            }
            if ($request->post('key') == 2) {
                $column = "fl_lower_arch";
                unlink($directory . $plan->fl_lower_arch);
            }
            if ($request->post('key') == 3) {
                $column = "fl_front";
                unlink($directory . $plan->fl_front);
            }
            if ($request->post('key') == 4) {
                $column = "fl_smile";
                unlink($directory . $plan->fl_smile);
            }
            if ($request->post('key') == 5) {
                $column = "fl_profile";
                unlink($directory . $plan->fl_profile);
            }
            if ($request->post('key') == 6) {
                $column = "fl_frontal";
                unlink($directory . $plan->fl_frontal);
            }
            if ($request->post('key') == 7) {
                $column = "fl_right_buccal";
                unlink($directory . $plan->fl_right_buccal);
            }
            if ($request->post('key') == 8) {
                $column = "fl_left_buccal";
                unlink($directory . $plan->fl_left_buccal);
            }
            if ($request->post('key') == 9) {
                $column = "fl_upper_occlusal";
                unlink($directory . $plan->fl_upper_occlusal);
            }
            if ($request->post('key') == 10) {
                $column = "fl_lower_occlusal";
                unlink($directory . $plan->fl_lower_occlusal);
            }
            if ($request->post('key') == 11) {
                $column = "fl_panorex";
                unlink($directory . $plan->fl_panorex);
            }
            if ($request->post('key') == 12) {
                $column = "fl_lateral_ceph";
                unlink($directory . $plan->fl_lateral_ceph);
            }
            if ($request->post('key') == 13) {
                $column = "fl_general_upload";
                unlink($directory . $plan->fl_general_upload);
            }

            if ($column != '') {
                DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
                    $column => null,
                ]);
            }
            return response()->json([
                "status" => "success"
            ]);
        }
        return response()->json([
            "status" => "error",
        ]);
    }
 public function fetchMesh($patient_id, $filename)
    {
        $directory = $this->mkDr($patient_id);
        $file_path = $directory . '/' . $filename;
        if(file_exists($file_path)) {
            header('Content-Type: application/octet-stream');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        } else {
            http_response_code(404);
    echo 'File not found.';
        }
    }
}
