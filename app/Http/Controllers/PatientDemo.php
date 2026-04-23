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
use Illuminate\Support\Facades\Schema;

class PatientDemo extends Controller
{
    public $hashids;
    public function __construct()
    {
        $this->middleware('auth');
         $this->hashids = new Hashids();
         View::share("hashids", $this->hashids);
    }
    public function see_demo($treatment_plan_id)
    {
        $patient = DB::table('demo_p_treatment_plans as tp')
        ->where('tp.id', $this->hashids->decode($treatment_plan_id))
        ->where('tp.is_deleted', 0)
        ->Join("demo_patients as p", function ($join) {
            $join->on("tp.patient_id", '=', "p.id")

                ->where('p.is_deleted', 0);
        })
        ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package")
        ->orderByDesc("p.id")
        ->first();

        $mode = "edit";
        return view("patients.demo", compact("patient", "mode"));
    }
    public function overview(Request $request, $phase)
    {
        $whereClauses = [["tp.id", $this->hashids->decode($phase)], ["tp.is_deleted", 0],];

        $patient = DB::table('demo_p_treatment_plans as tp')
            ->where($whereClauses)
            //->where('tp.is_submitted', 1)
            ->Join("demo_patients as p", function ($join) {
                $join->on("tp.patient_id", '=', "p.id")
                    ->where('p.is_deleted', 0);

            })
            ->leftJoin("users as l", function ($join) {
                $join->on("tp.lab", "=", "l.id")
                    ->where("l.role", "lab");
            })
            ->select("tp.*", "p.pricing_package", "p.first_name", "p.last_name", "p.dob", "p.user_id", "l.first_name as lab_first_name", "l.last_name as lab_last_name")
            ->first();
        if (@$patient) {
            $comments = [];
            $labs = [];
            $plans = [];

            $data = compact("patient", "labs", "comments", "plans", "phase");

            return view("patients.case_overview_demo", $data);
        }
        abort(403, 'Unauthorized request!');
    }

    public function iframe(Request $request, $phase)
    {
        $whereClauses = [["tp.id", $this->hashids->decode($phase)], ["tp.is_deleted", 0],];

        $patient = DB::table('demo_p_treatment_plans as tp')
            ->where($whereClauses)
            //->where('tp.is_submitted', 1)
            ->Join("demo_patients as p", function ($join) {
                $join->on("tp.patient_id", '=', "p.id")
                    ->where('p.is_deleted', 0);

            })
            ->leftJoin("users as l", function ($join) {
                $join->on("tp.lab", "=", "l.id")
                    ->where("l.role", "lab");
            })
            ->select("tp.*", "p.pricing_package", "p.first_name", "p.last_name", "p.dob", "p.user_id", "l.first_name as lab_first_name", "l.last_name as lab_last_name")
            ->first();
        if (@$patient) {
            $comments = [];
            $labs = [];
            $plans = [];

            $data = compact("patient", "labs", "comments", "plans", "phase");

            return view("patients.case_iframe", $data);
        }
        abort(403, 'Unauthorized request!');
    }

    public function delete_demo_patient($id)
    {
        DB::table('demo_patients')->where('id', $id)->where('is_deleted', 0)->update([
            "deleted_at" => date("Y-m-d H:i:s"),
            "is_deleted" => 1,
        ]);
        return redirect()->back()->with('success', 'Demo Patient deleted');
    }
    public function manage_demo_patients(Request $request)
    {
        $search = @$request->get('search');
        $patients = DB::table('demo_p_treatment_plans as tp')
        ->where('tp.is_deleted', 0)
        ->where('tp.is_submitted', 1)
        ->Join("demo_patients as p", function ($join) {
            $join->on("tp.patient_id", "=", "p.id")
            ->where("p.is_deleted", 0);
        })
        ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package")
        ->where(function ($query) use ($search) {
            if (!empty($search)) {
                $hash = $this->hashids->decode($search);
                if(count($hash) > 0) {
                    $query->where('p.id', $hash[0]);
                } else {
                    $query->where('p.dob', 'like', '%' . $search . '%')
                    ->orWhere('p.first_name', 'like', '%' . $search . '%')
                    ->orWhere('p.last_name', 'like', '%' . $search . '%');
                }
            }
        })
        ->orderByDesc('p.id')
        ->paginate(20);
        return view("patients.manage_demo_patients", compact("patients"));
    }
    public function add()
    {
        $patient = DB::table('demo_p_treatment_plans as tp')
            ->where('tp.is_deleted', 0)
            ->where('tp.is_submitted', 0)
            ->Join("demo_patients as p", function ($join) {
                $join->on("tp.patient_id", '=', "p.id")
                    ->whereNull("first_name")
                    ->whereNull("last_name")
                    ->whereNull("dob")
                    ->where('p.is_deleted', 0);
            })
            ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package")
            ->orderByDesc("p.id")
            ->first();
        if (!@$patient) {
            $latest = DB::table('demo_patients')->insertGetId([
                "user_id" => Auth::user()->id,
            ]);
            $phase = DB::table('demo_p_treatment_plans')->insertGetId([
                "patient_id" => $latest,
            ]);
            $patient = DB::table('demo_p_treatment_plans as tp')
                ->where('tp.is_deleted', 0)
                ->where('tp.is_submitted', 0)
                ->where('tp.id', $phase)
                ->Join("demo_patients as p", function ($join) {
                    $join->on("tp.patient_id", '=', "p.id")
                        ->where('p.is_deleted', 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package")
                ->first();
        } else {
            // Get the column names of the 'p_treatment_plans' table
            $tableName = 'demo_p_treatment_plans';
            $columns = Schema::getColumnListing($tableName);

            // Filter out columns without default values
            $columnDefaults = [];
            foreach ($columns as $column) {
                $columnInfo = DB::selectOne("SHOW COLUMNS FROM $tableName WHERE Field = '$column'");
                if ($columnInfo->Default !== null || $columnInfo->Null === 'YES') {
                    if ($column === 'created_at' && $columnInfo->Default === 'CURRENT_TIMESTAMP') {
                        $columnDefaults[$column] = DB::raw('CURRENT_TIMESTAMP');
                    } else {
                        $columnDefaults[$column] = DB::raw('DEFAULT');
                    }
                }
            }



            // Update the row with id in the 'p_treatment_plans' table
            DB::table($tableName)
                ->where('id', $patient->id)
                ->update($columnDefaults);

            DB::table('patients')->where('id', $patient->patient_id)->update([
                "created_at" => DB::raw('CURRENT_TIMESTAMP'),
            ]);

            $this->delete_demo_patient_storage_dir($patient->patient_id);
            $patient = DB::table('demo_p_treatment_plans as tp')
                ->where('tp.id', $patient->id)
                ->Join("demo_patients as p", function ($join) {
                    $join->on("tp.patient_id", '=', "p.id")
                        ->where('p.is_deleted', 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package")
                ->orderByDesc("p.id")
                ->first();
        }
        $mode = 'add';
        return view("patients.add_patient_demo", compact("patient", "mode"));
    }
    protected function delete_demo_patient_storage_dir($patient_id)
    {
        $directory = storage_path('/PatientDemoFiles/Patient' . $patient_id);

        // Check if directory exists
        if (File::exists($directory)) {

            // Get all files within the directory
            $files = File::allFiles($directory);

            // Delete each file within the directory
            foreach ($files as $file) {
                File::delete($file);
            }

            // Delete the directory itself
            File::deleteDirectory($directory);
        }
    }
    public function edit()
    {
        $patient = DB::table('demo_p_treatment_plans as tp')
        ->where('tp.id', 1)
        ->where('tp.is_deleted', 0)
        ->Join("demo_patients as p", function ($join) {
            $join->on("tp.patient_id", '=', "p.id")

                ->where('p.is_deleted', 0);
        })
        ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package")
        ->orderByDesc("p.id")
        ->first();

        $mode = "edit";
        return view("patients.add_patient_demo", compact("patient", "mode"));
    }
    public function save_patient_info(Request $request)
    {
        $first_name = $request->post('first_name');
        $last_name = $request->post('last_name');
        $dob = $request->post('dob');
        $id = $request->post('patient_id');
        DB::table('demo_patients')->where('id', $id)->update([
            "first_name" => $first_name,
            "last_name" => $last_name,
            "dob" => $dob,
        ]);
    }
    public function save_scan_data(Request $request)
    {
        $fl_upper_arch = $request->post('fl_upper_arch');
        $fl_lower_arch = $request->post('fl_lower_arch');
        $id = $request->post('patient_id');
        $treatment_plan_id = $request->post('treatment_plan_id');
        DB::table('demo_p_treatment_plans')->where('patient_id', $id)->where('id', $treatment_plan_id)->update([
            "fl_upper_arch" => $fl_upper_arch,
            "fl_lower_arch" => $fl_lower_arch,
        ]);
    }
    public function save_images(Request $request)
    {
        $id = $request->post('patient_id');
        $treatment_plan_id = $request->post('treatment_plan_id');
        DB::table('demo_p_treatment_plans')->where('patient_id', $id)->where('id', $treatment_plan_id)->update([
            "fl_general_upload_drive_link" => $request->post("hyperlink"),
        ]);
    }
    public function save_prescription(Request $request)
    {
        $data = [];
        $data['treat_upper_arch'] = $request->post('upper_arch');
        $data['treat_lower_arch'] = $request->post('lower_arch');
        $data['midline'] = $request->post('midline');
        $data['midline_notes'] = $request->post('midline_notes');
        $data['archform'] = $request->post('archform');
        $data['archform_notes'] = $request->post("archform_notes");
        $data['class'] = $request->post("class");
        $data['pcp_ur'] = serialize(json_decode($request->post('pcp_ur')));
        $data['pcp_lr'] = serialize(json_decode($request->post('pcp_lr')));
        $data['pcp_ul'] = serialize(json_decode($request->post('pcp_ul')));
        $data['pcp_ll'] = serialize(json_decode($request->post('pcp_ll')));
        $data['ctp_ur'] = serialize(json_decode($request->post('ctp_ur')));
        $data['ctp_lr'] = serialize(json_decode($request->post('ctp_lr')));
        $data['ctp_ul'] = serialize(json_decode($request->post('ctp_ul')));
        $data['ctp_ll'] = serialize(json_decode($request->post('ctp_ll')));
        $data['class_notes'] = $request->post("class_notes");
        $data['tooth_size_issues'] = $request->post("size_issues");
        $data['location_upper'] = $request->post('location_upper');
        $data['location_lower'] = $request->post('location_lower');
        $data['limits'] = $request->post('limits');
        $data['tmr_ur'] = serialize(json_decode($request->post('tmr_ur')));
        $data['tmr_lr'] = serialize(json_decode($request->post('tmr_lr')));
        $data['tmr_ul'] = serialize(json_decode($request->post('tmr_ul')));
        $data['tmr_ll'] = serialize(json_decode($request->post('tmr_ll')));
        $data['mut_ur'] = serialize(json_decode($request->post('mut_ur')));
        $data['mut_lr'] = serialize(json_decode($request->post('mut_lr')));
        $data['mut_ul'] = serialize(json_decode($request->post('mut_ul')));
        $data['mut_ll'] = serialize(json_decode($request->post('mut_ll')));
        $data['tbe_ur'] = serialize(json_decode($request->post('tbe_ur')));
        $data['tbe_lr'] = serialize(json_decode($request->post('tbe_lr')));
        $data['tbe_ul'] = serialize(json_decode($request->post('tbe_ul')));
        $data['tbe_ll'] = serialize(json_decode($request->post('tbe_ll')));
        $data['resolutions_notes'] = $request->post('resolution_notes');
        $data['occlusal_plane'] = $request->post('occlusal_plane');
        $data['occlusal_plane_notes'] = $request->post('occlusal_plane_notes');
        $data['additional_attachments'] = serialize(json_decode($request->post('additional_attachments')));
        $data['additional_attachments_notes'] = $request->post('additional_attachments_notes');
        $data['keep_already_placed_attachments'] = $request->post('keep_already_place_attachments');
        $data['trim_type_upper'] = $request->post('aligner_trim_type_upper');
        $data['trim_type_lower'] = $request->post('aligner_trim_type_lower');
        $data['is_prescription_submitted'] = 1;
        $id = $request->post('patient_id');
        $treatment_plan_id = $request->post('treatment_plan_id');
        DB::table('demo_p_treatment_plans')->where('patient_id', $id)->where('id', $treatment_plan_id)->update($data);
    }
    public function submit(Request $request)
    {
        $id = $request->post('patient_id');
        $phase = $request->post('treatment_plan_id');
        $preferred_package = @$request->post('client_preferred_package');
        $iframe_link = $request->post('iframe_link');
        $patient = DB::table('demo_p_treatment_plans as tp')
            ->where('tp.is_deleted', 0)
            //->where('tp.is_submitted', 0)
            ->where('tp.id', $phase)
            ->Join("demo_patients as p", function ($join) {
                $join->on("tp.patient_id", '=', "p.id")
                    ->where('p.is_deleted', 0);
            })
            ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package", "p.nemotech_patient_id")
            ->first();
        if (@$patient) {
            if($iframe_link != "") {
                DB::table('demo_p_treatment_plans')->where('id', $phase)->update([
                    "iframe_link" => $iframe_link,
                ]);
            }
            if($patient->phase == 1) {
                if(!in_array($preferred_package, ['select', 'confidence'])) {
                    'Enable to submit. Make sure you have completely filled all required sections.';
                }
                $package = 'AL-SECRET-SELECT';
                if($preferred_package == 'confidence') {
                    $package = 'AL-SECRET-CONFIDENCE';
                }
                DB::table('demo_patients')->where('id', $patient->patient_id)->update([
                    "pricing_package" => $package,
                ]);
            }
            if ($patient->first_name && $patient->last_name && $patient->dob) {

                if ($patient->fl_upper_arch && $patient->fl_lower_arch && $patient->fl_front && $patient->fl_smile && $patient->fl_profile && $patient->fl_frontal && $patient->fl_right_buccal && $patient->fl_left_buccal && $patient->fl_upper_occlusal && $patient->fl_lower_occlusal && $patient->fl_panorex && $patient->fl_lateral_ceph) {
                    if (($patient->treat_upper_arch == 1 || $patient->treat_lower_arch == 1) && $patient->is_prescription_submitted == 1) {
                        if($patient->is_editable == 1) {
                            return redirect()->back()->with("success", "Patient Case Edited!");
                        }
                        DB::table('demo_p_treatment_plans')->where('id', $phase)->update([
                            "is_submitted" => 1,
                            "status" => "In Progress",
                            "is_editable" => 0,
                        ]);
                        return redirect()->back()->with('success', 'Patient added');
                    }
                }
            }
        }
        return redirect()->back()->with('error', 'Enable to submit. Make sure you have completely filled all required sections.');
    }

    public function validatePatientData(Request $request)
    {
        $id = $request->post('patient_id');
        $phase = $request->post('treatment_plan_id');
        $patient = DB::table('demo_p_treatment_plans as tp')
            ->where('tp.is_deleted', 0)
            //->where('tp.is_submitted', 0)
            ->where('tp.id', $phase)
            ->Join("demo_patients as p", function ($join) {
                $join->on("tp.patient_id", '=', "p.id")
                    ->where('p.user_id', Auth::user()->id)
                    ->where('p.is_deleted', 0);
            })
            ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package")
            ->first();
           // dd($patient);
        $fn1 = 0;
        $fn2 = 0;
        $fn3 = 0;
        $fn4 = 0;
        if (@$patient) {
            if ($patient->first_name && $patient->last_name && $patient->dob) {
                $fn1 = 1;
            }
            if ($patient->fl_upper_arch && $patient->fl_lower_arch) {
                $fn2 = 1;
            }
            if ($patient->fl_front && $patient->fl_smile && $patient->fl_profile && $patient->fl_frontal && $patient->fl_right_buccal && $patient->fl_left_buccal && $patient->fl_upper_occlusal && $patient->fl_lower_occlusal && $patient->fl_panorex && $patient->fl_lateral_ceph) {
                $fn3 = 1;
            }
            if (($patient->treat_upper_arch == 1 || $patient->treat_lower_arch == 1) && $patient->is_prescription_submitted == 1) {
                $fn4 = 1;
            }
        }
        dd($patient,$fn1,$fn2,$fn3,$phase,$id);
        return response()->json([
            "patient" => $patient,
            "fn1" => $fn1,
            "fn2" => $fn2,
            "fn3" => $fn3,
            "fn4" => $fn4,
        ]);
    }

    protected function mkDr($patient_id)
    {
        $directory = storage_path('/PatientDemoFiles/Patient' . $patient_id);

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true, true);
            $directory = storage_path('/PatientDemoFiles/Patient' . $patient_id);
        }
        return $directory;
    }
    private function ThreeShapeSaveSTL($patient_id, $treatment_plan_id, $column, $caseId, $hash)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => env('THREE_SHAPE_API_REGION_URI').'/api/cases/'.$caseId.'/attachments/'.$hash,
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
DB::table('demo_p_treatment_plans')->where('id', $treatment_plan_id)->update([
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
    {dd(":fbdnfv");
        if (DB::table('demo_p_treatment_plans')->where('patient_id', $patient_id)->where('id', $treatment_plan_id)->exists()) {
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

            if ($column != '') {
                DB::table('demo_p_treatment_plans')->where('id', $treatment_plan_id)->update([
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
        $plan = DB::table('demo_p_treatment_plans')->where('patient_id', $patient_id)->where('id', $treatment_plan_id)->first();
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
                DB::table('demo_p_treatment_plans')->where('id', $treatment_plan_id)->update([
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
    public function stlViewer(){
        return view('demostl');
    }
}
