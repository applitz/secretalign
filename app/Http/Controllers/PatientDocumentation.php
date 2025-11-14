<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;

class PatientDocumentation extends Controller
{
    public $hashids;
    public function __construct()
    {
        $this->middleware(['auth', 'auth.doctor']);
        $this->hashids = new Hashids();
        View::share("hashids", $this->hashids);
    }
    public function documentation($treatment_plan_id)
    {
        $patient = DB::table('p_treatment_plans as tp')
        ->where('tp.is_deleted', 0)
        ->where('tp.id', $this->hashids->decode($treatment_plan_id))

        ->Join("patients as p", function ($join) {
            $join->on("tp.patient_id", '=', "p.id")
                ->where('p.user_id', Auth::user()->id)
                ->where('p.is_deleted', 0);
        })
        ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package")
        ->orderByDesc("p.id")
        ->first();
        if(@$patient) {
            $before = $patient;
            $after = DB::table('patients_history')->where('treatment_plan_id', $patient->id)->where('type', 'after')->first();
            if(!@$before) {
                $id = DB::table('patients_history')->insertGetId([
                    "treatment_plan_id" => $patient->id,
                    "type" => "before",
                ]);
                $before = DB::table('patients_history')->where('treatment_plan_id', $patient->id)->where('type', 'before')->first();
            }
            if(!@$after) {
                $id = DB::table('patients_history')->insertGetId([
                    "treatment_plan_id" => $patient->id,
                    "type" => "after",
                ]);
                $after = DB::table('patients_history')->where('treatment_plan_id', $patient->id)->where('type', 'after')->first();
            }
            return view("patients.documentation", compact("patient", "before", "after"));
        }
    }
    protected function mkDr($patient_id)
    {
        $directory = storage_path('/PatientFiles/Patient' . $patient_id . '/Documentation');

        if (!File::exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
        return $directory;
    }
    public function file_upload(Request $request, $patient_id, $treatment_plan_id)
    {


        if (DB::table('p_treatment_plans')->where('patient_id', $patient_id)->where('id', $treatment_plan_id)->exists()) {
            $attachment = $_FILES['attachment']['name'];
            $file_tmp = $_FILES['attachment']['tmp_name'];
            $filename = str_replace(' ', '-', $_FILES['attachment']['name']);

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

            $request->file('attachment')->move($directory, $filename);

            $column = '';
            if ($request->get('id') == 1 || $request->get('id') == 14) {
                $column = "fl_upper_arch";
            }
            if ($request->get('id') == 2 || $request->get('id') == 15) {
                $column = "fl_lower_arch";
            }
            if ($request->get('id') == 3 || $request->get('id') == 16) {
                $column = "fl_front";
            }
            if ($request->get('id') == 4 || $request->get('id') == 17) {
                $column = "fl_smile";
            }
            if ($request->get('id') == 5 || $request->get('id') == 18) {
                $column = "fl_profile";
            }
            if ($request->get('id') == 6 || $request->get('id') == 19) {
                $column = "fl_frontal";
            }
            if ($request->get('id') == 7 || $request->get('id') == 20) {
                $column = "fl_right_buccal";
            }
            if ($request->get('id') == 8 || $request->get('id') == 21) {
                $column = "fl_left_buccal";
            }
            if ($request->get('id') == 9 || $request->get('id') == 22) {
                $column = "fl_upper_occlusal";
            }
            if ($request->get('id') == 10 || $request->get('id') == 23) {
                $column = "fl_lower_occlusal";
            }
            if ($request->get('id') == 11 || $request->get('id') == 24) {
                $column = "fl_panorex";
            }
            if ($request->get('id') == 12 || $request->get('id') == 25) {
                $column = "fl_lateral_ceph";
            }
            if ($request->get('id') == 13 || $request->get('id') == 26) {
                $column = "fl_general_upload";
            }

            if ($column != '') {
                if($request->get('id') > 13) {
                    $history = DB::table('patients_history')->where('treatment_plan_id', $treatment_plan_id)->where('type', 'after')->first();
                    if($history->{$column}) {
                        if(File::exists($directory . '/'. $history->{$column})) {
                            unlink($directory . '/' . $history->{$column});
                        }
                    }
                    DB::table('patients_history')->where('treatment_plan_id', $treatment_plan_id)->where('type', 'after')->update([
                        $column => $filename,
                    ]);
                } else {
                    $history = DB::table('patients_history')->where('treatment_plan_id', $treatment_plan_id)->where('type', 'before')->first();
                    if($history->{$column}) {
                        if(File::exists($directory . '/'. $history->{$column})) {
                            unlink($directory . '/' . $history->{$column});
                        }
                    }
                    DB::table('patients_history')->where('treatment_plan_id', $treatment_plan_id)->where('type', 'before')->update([
                        $column => $filename,
                    ]);
                }
            }



            echo json_encode($filename);
        }
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
        if (DB::table('p_treatment_plans')->where('patient_id', $patient_id)->where('id', $treatment_plan_id)->exists()) {
            $directory = $this->mkDr($patient_id) . '/';
            $key = str_replace('"', "", $request->key);
            unlink($directory . $key);
            $column = '';
            if ($request->get('id') == 1) {
                $column = "fl_upper_arch";
            }
            if ($request->get('id') == 2) {
                $column = "fl_lower_arch";
            }
            if ($request->get('id') == 3) {
                $column = "fl_front";
            }
            if ($request->get('id') == 4) {
                $column = "fl_smile";
            }
            if ($request->get('id') == 5) {
                $column = "fl_profile";
            }
            if ($request->get('id') == 6) {
                $column = "fl_frontal";
            }
            if ($request->get('id') == 7) {
                $column = "fl_right_buccal";
            }
            if ($request->get('id') == 8) {
                $column = "fl_left_buccal";
            }
            if ($request->get('id') == 9) {
                $column = "fl_upper_occlusal";
            }
            if ($request->get('id') == 10) {
                $column = "fl_lower_occlusal";
            }
            if ($request->get('id') == 11) {
                $column = "fl_panorex";
            }
            if ($request->get('id') == 12) {
                $column = "fl_lateral_ceph";
            }
            if ($request->get('id') == 13) {
                $column = "fl_general_upload";
            }

            if ($column != '') {
                DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
                    $column => null,
                ]);
            }
            echo json_encode(1);
        }
    }
}
