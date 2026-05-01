<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Services\TaskService;
use App\Http\Services\NemoTechService;
use App\Jobs\SubmitCaseMailJob;
use App\Jobs\SubmitCaseMailStaffJob;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\MeditLink;
use Exception;
use Illuminate\Support\Facades\Log;

class RegisterPatient extends Controller
{
    public $hashids;
    public function __construct()
    {
        $this->middleware(['auth', 'auth.doctor']);
        $this->hashids = new Hashids();
        View::share("hashids", $this->hashids);
    }
    private function MeditLinkRefreshToken()
    {
        $curl = curl_init();
        $token= MeditLink::where('user_id',Auth::id())->orderBy('id','desc')->first();

        curl_setopt_array($curl, array(
           // CURLOPT_URL => 'https://'.env("MEDIT_LINK_OPENAPI_SERVER").'-openapi-auth.meditlink.com/oauth/token',
           CURLOPT_URL => 'https://stage-openapi-auth.meditlink.com/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=refresh_token&refresh_token='.Auth::user()->medit_link_refresh_token,
            CURLOPT_HTTPHEADER => array(
               // 'Host: '.env("MEDIT_LINK_OPENAPI_SERVER").'-openapi-auth.meditlink.com',
               'Host: stage-openapi-auth.meditlink.com',
                'Authorization: Basic ' . base64_encode(env("MEDIT_LINK_CLIENT_ID").":".env("MEDIT_LINK_CLIENT_KEY")),
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        if(@$response->access_token) {
            DB::table('users')->where('id', Auth::user()->id)->update([
                "medit_link_access_token" => @$response->access_token,
                "medit_link_refresh_token" => @$response->refresh_token,
            ]);


        } else {
            DB::table('users')->where('id', Auth::user()->id)->update([
                "medit_link_access_token" => null,
            ]);
        }

    }
    private function ThreeShapeRefreshToken()
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => env('THREE_SHAPE_API_URI').'/connect/token',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'client_id='.env('THREE_SHAPE_CLIENT_ID').'&grant_type=refresh_token&refresh_token='.Auth::user()->three_shape_refresh_token,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);

        if(@$response->access_token) {
            DB::table('users')->where('id', Auth::user()->id)->update([
                "three_shape_access_token" => @$response->access_token,
                "three_shape_refresh_token" => @$response->refresh_token,
            ]);
        } else {
            DB::table('users')->where('id', Auth::user()->id)->update([
                "three_shape_access_token" => null,
            ]);
        }

    }
    public function edit(Request $request, $treatment_plan_id)
    {
        $baseUrl = null;
        $code = null;
        $changePlan = 'true';
        $dataShining3d = [];
        $scanError = null;
        $baseUrl = null;
        $code = null;
        $orderList = [];
        if($request->has('code') && $request->has('codeChallenge') && $request->has('matchNode') && $request->has('domain')) {

            $shining3d_user_id = Auth::user()->shining3d_user_id;
            $shining3d_org_code = Auth::user()->shining3d_org_code;
            $baseUrl = $request->get('domain');
            $code = $request->get('code');

            $csrfToken = getDynamicEncryptionToken($baseUrl);
            if($csrfToken['status'] == 'success') {
                $dataShining3d['csrfToken'] = $csrfToken['result'];
                $connectionAuthorization = json_decode(connect($baseUrl, $csrfToken['result']), true);
                if($connectionAuthorization['status'] == 'success') {
                    $dataShining3d['connectionAuthorization'] = $connectionAuthorization;
                    $userDetails = exchangeCodeForToken($code, $baseUrl);
                    if($userDetails['status'] == 'success') {
                        if($userDetails['result'] && $userDetails['result']['factories'] && count($userDetails['result']['factories']) > 0) {
                            // Find clinic by name
                            $userId = $userDetails['result']['userId'];
                            $dataShining3d['userId'] = $userId;
                            $clinic = collect($userDetails['result']['factories'])->firstWhere('name', Auth::user()->shining3d_org_name);
                            if($clinic) {
                                $orgCode = $clinic['orgCode'];
                                $dataShining3d['orgCode'] = $orgCode;
                                $objUser = User::find(Auth::user()->id);
                                $objUser->shining3d_user_id = $userId;
                                $objUser->shining3d_org_code = $orgCode;
                                $objUser->save();
                                $dataDistribution = $clinic['dataDistribution'];
                                $dataShining3d['dataDistribution'] = $dataDistribution;
                                if(count($dataDistribution) > 0){
                                    $dataShining3d['endDate']   = date('Y-m-d');
                                    $dataShining3d['startDate'] = date('Y-m-d',strtotime($dataShining3d['endDate'] . ' -3 days'));

                                    $dataShining3d['orderList'] = getOrderList($baseUrl, $connectionAuthorization['result'], $orgCode, $userId, $clinic['orgType'], $dataShining3d['startDate'], $dataShining3d['endDate']);
                                    $dataShining3d['baseUrl'] = $baseUrl;
                                    $dataShining3d['authToken'] = $connectionAuthorization['result'];
                                    $dataShining3d['orgCode'] = $orgCode;
                                    $dataShining3d['doctorId'] = $userId;
                                    $dataShining3d['orgType'] = $clinic['orgType'];

                                    Log::info('SHINING 3D connection successful', ['user_id' => Auth::id(), 'clinic' => $clinic, 'shining3d_user_id' => $userId, 'org_code' => $orgCode]);
                                }
                            }
                            $scanError = 'Failed to find clinic in SHINING 3D.';
                        }
                        $scanError = 'Failed to retrieve user details from SHINING 3D.';
                    }
                    $scanError = 'Failed to exchange authorization code with SHINING 3D.';
                }
                $scanError = 'Failed to establish secure connection with SHINING 3D.';
            }
            $scanError = 'Failed to generate secure authentication token from SHINING 3D.';
        }


        if(Auth::user()->three_shape_refresh_token != null) {
            $this->ThreeShapeRefreshToken();
        }
        if(Auth::user()->medit_link_refresh_token != null) {
            $this->MeditLinkRefreshToken();
        }
        $advisors = User::where('role','advisor')->get();
        $patient = DB::table('p_treatment_plans as tp')
            ->where('tp.is_deleted', 0)
            ->where('tp.id', $this->hashids->decode($treatment_plan_id))

            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", '=', "p.id")
                    ->where('p.user_id', Auth::user()->id)
                    ->where('p.is_deleted', 0);
            })
            ->select("tp.*", "p.first_name", "p.last_name", "p.id as patient_id",  "p.dob", "p.user_id", "p.pricing_package")
            ->orderByDesc("p.id")
            ->first();

        $priviousPatientDetails = DB::table('p_treatment_plans as tp')
            ->where('tp.is_deleted', 0)
            ->where('tp.id', '!=', $this->hashids->decode($treatment_plan_id))
            ->where('tp.patient_id', $patient->patient_id)
            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", '=', "p.id")
                    ->where('p.user_id', Auth::user()->id)
                    ->where('p.is_deleted', 0);
            })
            ->select("tp.*", "p.first_name", "p.last_name", "p.id as patient_id",  "p.dob", "p.user_id", "p.pricing_package")
            ->orderByDesc("tp.id")
            ->first();

        $getTreatmentType = DB::table('p_treatment_plans as tp')
                            ->where('tp.is_deleted', 0)
                            ->where('tp.patient_id', $patient->patient_id)
                            ->where('tp.id', '!=', $patient->id)
                            ->orderBy('tp.id', 'desc')
                            ->select('treatment_type')
                            ->get()
                            ->first();
                            if($getTreatmentType){
                                if($getTreatmentType->treatment_type == 2){
                                    $changePlan = 'true';
                                } else {
                                    $changePlan = 'false';
                                }
                            }
        if (@$patient) {

            $hashids = new Hashids();
            $hashCode = $hashids->encode($patient->id);
            $mode = "edit";
            if ($patient->is_submitted == 1) {
                if ($patient->is_editable == 1) {
                    return view("patients.add_patient", compact("patient", "mode","advisors", "changePlan", "priviousPatientDetails",  'baseUrl', 'code', 'hashCode', 'dataShining3d', 'scanError'));
                }

            } else {
                 return view("patients.add_patient", compact("patient", "mode","advisors", "changePlan", "priviousPatientDetails",  'baseUrl', 'code', 'hashCode', 'dataShining3d', 'scanError'));
            }
        }
        abort(403, "Unauthorized request!");
    }

    private function splitByLastSpace($string) {
        $lastSpacePos = strrpos($string, ' ');
        if ($lastSpacePos === false) {
            return [$string];
        }
        $firstPart = substr($string, 0, $lastSpacePos);
        $secondPart = substr($string, $lastSpacePos + 1);
        return [$firstPart, $secondPart];
    }
    public function create(Request $request)
    {
        $dataShining3d = [];
        $scanError = null;
        $baseUrl = null;
        $code = null;
        $orderList = [];
        if($request->has('code') && $request->has('codeChallenge') && $request->has('matchNode') && $request->has('domain')) {

            $shining3d_user_id = Auth::user()->shining3d_user_id;
            $shining3d_org_code = Auth::user()->shining3d_org_code;
            $baseUrl = $request->get('domain');
            $code = $request->get('code');

            $csrfToken = getDynamicEncryptionToken($baseUrl);
            if($csrfToken['status'] == 'success') {
                $dataShining3d['csrfToken'] = $csrfToken['result'];
                $connectionAuthorization = json_decode(connect($baseUrl, $csrfToken['result']), true);
                if($connectionAuthorization['status'] == 'success') {
                    $dataShining3d['connectionAuthorization'] = $connectionAuthorization;
                    $userDetails = exchangeCodeForToken($code, $baseUrl);
                    if($userDetails['status'] == 'success') {
                        if($userDetails['result'] && $userDetails['result']['factories'] && count($userDetails['result']['factories']) > 0) {
                            // Find clinic by name
                            $userId = $userDetails['result']['userId'];
                            $dataShining3d['userId'] = $userId;
                            $clinic = collect($userDetails['result']['factories'])->firstWhere('name', Auth::user()->shining3d_org_name);
                            if($clinic) {
                                $orgCode = $clinic['orgCode'];
                                $dataShining3d['orgCode'] = $orgCode;
                                $objUser = User::find(Auth::user()->id);
                                $objUser->shining3d_user_id = $userId;
                                $objUser->shining3d_org_code = $orgCode;
                                $objUser->save();
                                $dataDistribution = $clinic['dataDistribution'];
                                $dataShining3d['dataDistribution'] = $dataDistribution;
                                if(count($dataDistribution) > 0){
                                    $dataShining3d['endDate']   = date('Y-m-d');
                                    $dataShining3d['startDate'] = date('Y-m-d',strtotime($dataShining3d['endDate'] . ' -3 days'));

                                    $dataShining3d['orderList'] = getOrderList($baseUrl, $connectionAuthorization['result'], $orgCode, $userId, $clinic['orgType'], $dataShining3d['startDate'], $dataShining3d['endDate']);
                                    $dataShining3d['baseUrl'] = $baseUrl;
                                    $dataShining3d['authToken'] = $connectionAuthorization['result'];
                                    $dataShining3d['orgCode'] = $orgCode;
                                    $dataShining3d['doctorId'] = $userId;
                                    $dataShining3d['orgType'] = $clinic['orgType'];

                                    Log::info('SHINING 3D connection successful', ['user_id' => Auth::id(), 'clinic' => $clinic, 'shining3d_user_id' => $userId, 'org_code' => $orgCode]);
                                }
                            }
                            $scanError = 'Failed to find clinic in SHINING 3D.';
                        }
                        $scanError = 'Failed to retrieve user details from SHINING 3D.';
                    }
                    $scanError = 'Failed to exchange authorization code with SHINING 3D.';
                }
                $scanError = 'Failed to establish secure connection with SHINING 3D.';
            }
            $scanError = 'Failed to generate secure authentication token from SHINING 3D.';
        }

        //DB::BeginTransaction();
        if(Auth::user()->three_shape_refresh_token != null) {
            $this->ThreeShapeRefreshToken();
        }
        if(Auth::user()->medit_link_refresh_token != null) {
            $this->MeditLinkRefreshToken();
        }
        $advisors = User::where('role','advisor')->get();
        $medit_data = null;

        if(@session()->exists('medit_pending_data')) {
            $medit_data = json_decode(session()->get('medit_pending_data'));
           // dd($medit_data);
            if(@$medit_data->ip == $request->ip()) {
                if(!Auth::user()->medit_link_access_token) {
                    $integration = new \App\Http\Controllers\IntegrationController;
                    return $integration->MeditLinkObtainAuthorizationCode();
                }
            }
        }
        $first_name = null;
        $last_name = null;
        $dob = null;
        if(@$medit_data->name) {
            $name = $this->splitByLastSpace($medit_data->name);
            $first_name = @$name[0];
            $last_name = @$name[1];
            $dob = $medit_data->dob;
           // $dob = $medit_data->dob;
        }
        $patient = DB::table('p_treatment_plans as tp')
            ->where('tp.is_deleted', 0)
            ->where('tp.is_submitted', 0)
            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", '=', "p.id")
                    ->where('p.user_id', Auth::user()->id)
                    ->whereNull("first_name")
                    ->whereNull("last_name")
                    ->whereNull("dob")
                    ->where('p.is_deleted', 0);
            })
            ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package")
            ->orderByDesc("p.id")
            ->first();
        if (!@$patient) {
            $latest = DB::table('patients')->insertGetId([
                "user_id" => Auth::user()->id,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "dob" => $dob,
              //  "patientId" => $dob,
            ]);
            $phase = DB::table('p_treatment_plans')->insertGetId([
                "patient_id" => $latest,
            ]);
            $patient = DB::table('p_treatment_plans as tp')
                ->where('tp.is_deleted', 0)
                ->where('tp.is_submitted', 0)
                ->where('tp.id', $phase)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", '=', "p.id")
                        ->where('p.user_id', Auth::user()->id)
                        ->where('p.is_deleted', 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package")
                ->first();
        } else {
            // Get the column names of the 'p_treatment_plans' table
            $tableName = 'p_treatment_plans';
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
                "first_name" => $first_name,
                "last_name" => $last_name,
                "dob" => $dob,
            ]);

            $this->delete_patient_storage_dir($patient->patient_id);
            $patient = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $patient->id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", '=', "p.id")
                        ->where('p.user_id', Auth::user()->id)
                        ->where('p.is_deleted', 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package")
                ->orderByDesc("p.id")
                ->first();
        }
        $mode = 'add';
        if (Auth::user()->role == 'doctor') {

            // Fetch the treatment plan for the patient
            $treatment_plan = DB::table('p_treatment_plans')->where('id', $patient->id)->first();

            // Ensure $treatment_plan is not null
            if (!$treatment_plan) {
                // Handle the case where the treatment plan does not exist (optional)
                return response()->json(['error' => 'Treatment plan not found.'], 404);
            }


            $treatment_plan_id = $treatment_plan->id;
            // Get the id from the object

            $treatment_plan_details = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                         ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.user_id", "p.pricing_package")
                ->first();

            if (@$treatment_plan_details->case_holder == 'doctor') {

                $task = (new TaskService($treatment_plan_id));

                $task->complete_task("doctor", $treatment_plan_details->user_id); // Complete doctor task

              //  $task_id = $task->create_task("staff", "Case Review for Staff", 'doctor', $comment, "doctor", "staff", null); // Comment from doctor to staff


            }

        }

        if(@session()->exists('medit_pending_data')) {
            session()->forget('medit_pending_data');
        }

        if (session()->has('patient_id')) {
            $patient_id = session('patient_id');
            $patient = DB::table('p_treatment_plans as tp')
                ->where('tp.patient_id', $patient_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", '=', "p.id")
                        ->where('p.user_id', Auth::user()->id)
                        ->where('p.is_deleted', 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package")
                ->orderByDesc("p.id")
                ->first();
            session()->forget('patient_id');
        }

         $hashids = new Hashids();
            $hashCode = $hashids->encode($patient->id);
    // dd($dataShining3d);
        $changePlan = 'true';
        return view("patients.add_patient", compact("patient", "mode", "medit_data","advisors", 'changePlan', 'baseUrl', 'code', 'dataShining3d', 'scanError', 'hashCode'));
    }

    protected function delete_patient_storage_dir($patient_id)
    {
        $directory = storage_path('/PatientFiles/Patient' . $patient_id);

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

    public function selected_plan(Request $request){
        $treatment_type = $request->post('treatment_type');
        $patient_id = $request->post('patient_id');
        $treatment_plan_id = $request->post('treatment_plan_id');
        DB::table('p_treatment_plans')->where('patient_id', $patient_id)->where('id', $treatment_plan_id)->update([
            "treatment_type" => $treatment_type,
        ]);
    }

    public function save_patient_info(Request $request)
    {
        $first_name = $request->post('first_name');
        $last_name = $request->post('last_name');
        $dob = $request->post('dob');
        $id = $request->post('patient_id');
        DB::table('patients')->where('id', $id)->update([
            "first_name" => $first_name,
            "last_name" => $last_name,
            "dob" => $dob,
        ]);
        session(['patient_id' => $id]);
    }
    public function save_scan_data(Request $request)
    {
        $fl_upper_arch = $request->post('fl_upper_arch');
        $fl_lower_arch = $request->post('fl_lower_arch');
        $id = $request->post('patient_id');
        $treatment_plan_id = $request->post('treatment_plan_id');
        DB::table('p_treatment_plans')->where('patient_id', $id)->where('id', $treatment_plan_id)->update([
            "fl_upper_arch" => $fl_upper_arch,
            "fl_lower_arch" => $fl_lower_arch,
        ]);
    }
    public function save_images(Request $request)
    {
        $id = $request->post('patient_id');
        $treatment_plan_id = $request->post('treatment_plan_id');
        DB::table('p_treatment_plans')->where('patient_id', $id)->where('id', $treatment_plan_id)->update([
            "fl_general_upload_drive_link" => $request->post("hyperlink"),
        ]);
    }



    public function save_prescription(Request $request)
    {
        $data = [];
        $data['treat_upper_arch'] = $request->post('upper_arch');
        $data['treat_lower_arch'] = $request->post('lower_arch');
        $data['midline'] = $request->post('midline');
        $data['align_to_facial_midline'] = $request->post('align_to_facial_midline');
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

        $data['button_inner'] = implode(',', json_decode($request->post('button_inner'), true) ?? []);
        $data['button_outer'] = implode(',', json_decode($request->post('button_outer'), true) ?? []);
        $data['ihook_outer'] = implode(',', json_decode($request->post('ihook_outer'), true) ?? []);
        $data['ihook_inner'] = implode(',', json_decode($request->post('ihook_inner'), true) ?? []);
        $data['precision_cut_outer'] = implode(',', json_decode($request->post('precision_cut_outer'), true) ?? []);
        $data['precision_cut_inner'] = implode(',', json_decode($request->post('precision_cut_inner'), true) ?? []);
        $data['power_arm_attachment_outer'] = implode(',', json_decode($request->post('power_arm_attachment_outer'), true) ?? []);
        $data['power_arm_attachment_inner'] = implode(',', json_decode($request->post('power_arm_attachment_inner'), true) ?? []);
        $data['power_ridge_outer'] = implode(',', json_decode($request->post('power_ridge_outer'), true) ?? []);
        $data['power_ridge_inner'] = implode(',', json_decode($request->post('power_ridge_inner'), true) ?? []);
        $data['bite_turbos'] = implode(',', json_decode($request->post('bite_turbos'), true) ?? []);
        $data['bite_ramp'] = implode(',', json_decode($request->post('bite_ramp'), true) ?? []);

        $data['unerupted_teeth'] = implode(',', json_decode($request->post('unerupted_teeth'), true) ?? []);
        $data['extracted_teeth'] = implode(',', json_decode($request->post('extracted_teeth'), true) ?? []);
        $data['tooth_movement_restrictions'] = implode(',', json_decode($request->post('tooth_movement_restrictions'), true) ?? []);
        $data['coil'] = implode(',', json_decode($request->post('coil'), true) ?? []);
        $data['pontic'] = implode(',', json_decode($request->post('pontic'), true) ?? []);
        $data['bridge'] = implode(',', json_decode($request->post('bridge'), true) ?? []);

        $data['ihook_ur'] = serialize(json_decode($request->post('ihook_ur')));
        $data['ihook_lr'] = serialize(json_decode($request->post('ihook_lr')));
        $data['ihook_ul'] = serialize(json_decode($request->post('ihook_ul')));
        $data['ihook_ll'] = serialize(json_decode($request->post('ihook_ll')));
        $data['class_notes'] = $request->post("class_notes");
        $data['tooth_size_issues'] = $request->post("size_issues");
        $data['location_upper'] = $request->post('location_upper');
        $data['location_lower'] = $request->post('location_lower');
        $data['limits'] = $request->post('limits');
        $data['ofp_ur'] = serialize(json_decode($request->post('ofp_ur')));
        $data['ofp_lr'] = serialize(json_decode($request->post('ofp_lr')));
        $data['ofp_ul'] = serialize(json_decode($request->post('ofp_ul')));
        $data['ofp_ll'] = serialize(json_decode($request->post('ofp_ll')));
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
        $data['tla_ur'] = serialize(json_decode($request->post('tla_ur')));
        $data['tla_lr'] = serialize(json_decode($request->post('tla_lr')));
        $data['tla_ul'] = serialize(json_decode($request->post('tla_ul')));
        $data['tla_ll'] = serialize(json_decode($request->post('tla_ll')));

        $data['add_pontic_ur'] = serialize(json_decode($request->post('add_pontic_ur')));
        $data['add_pontic_ul'] = serialize(json_decode($request->post('add_pontic_ul')));
        $data['add_pontic_lr'] = serialize(json_decode($request->post('add_pontic_lr')));
        $data['add_pontic_ll'] = serialize(json_decode($request->post('add_pontic_ll')));

        $data['add_bite_turbos_ur'] = serialize(json_decode($request->post('add_bite_turbos_ur')));
        $data['add_bite_turbos_ul'] = serialize(json_decode($request->post('add_bite_turbos_ul')));
        $data['add_bite_turbos_lr'] = serialize(json_decode($request->post('add_bite_turbos_lr')));
        $data['add_bite_turbos_ll'] = serialize(json_decode($request->post('add_bite_turbos_ll')));

        $data['resolutions_notes'] = $request->post('resolution_notes');
        $data['occlusal_plane'] = $request->post('occlusal_plane');
        $data['occlusal_plane_notes'] = $request->post('occlusal_plane_notes');

        $data['aesthetic_start'] = $request->post('aesthetic_start');
        $data['anterior_leveling'] = $request->post('anterior_leveling');

        $data['additional_attachments'] = serialize(json_decode($request->post('additional_attachments')));
        $data['additional_attachments_notes'] = $request->post('additional_attachments_notes');
        $data['keep_already_placed_attachments'] = $request->post('keep_already_place_attachments');

        $data['trim_type_upper'] = $request->post('aligner_trim_type_upper');
        $data['trim_type_upper_straight_upper'] = $request->post('trim_type_upper_upper');
        $data['trim_type_lower'] = $request->post('aligner_trim_type_lower');
        $data['trim_type_lower_straight_lower'] = $request->post('trim_type_lower_upper');

        $data['is_prescription_submitted'] = 1;
        $id = $request->post('patient_id');
        $treatment_plan_id = $request->post('treatment_plan_id');
       // dd($data);
        DB::table('p_treatment_plans')->where('patient_id', $id)->where('id', $treatment_plan_id)->update($data);
    }

    public function submit(Request $request)
    {
        $id = $request->post('patient_id');
        $phase = $request->post('treatment_plan_id');
        $preferred_package = @$request->post('client_preferred_package');
        $setup_type = @$request->post('client_setup_type');
        $comment = $request->comment;
        $advisor_id = $request->advisor;
        // dd($advisor_id === null , $advisor_id === '');
        $patient = DB::table('p_treatment_plans as tp')
            ->where('tp.is_deleted', 0)
            //->where('tp.is_submitted', 0)
            ->where('tp.id', $phase)
            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", '=', "p.id")
                    ->where('p.user_id', Auth::user()->id)
                    ->where('p.is_deleted', 0);
            })
            ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package", "p.nemotech_patient_id")
            ->first();

        $details = [
            'subject' => 'Order Received - Review in Progress',
            'doctor_name' => Auth::user()->first_name." ".Auth::user()->last_name,
            'patient_name' => $patient->first_name." ".$patient->last_name,
            'email' => Auth::user()->email,
        ];
        SubmitCaseMailJob::dispatch($details);
        $staff = DB::table('users')
                    ->where('role', 'staff')
                    ->get(['first_name', 'last_name', 'email'])
                    ->toArray();

        SubmitCaseMailStaffJob::dispatch($staff, $details);
        if($patient->recommended_advisor != null)
        {
            $advisor_id = $patient->recommended_advisor;
        }

        if (@$patient) {

            if($patient->phase == 1 && $patient->is_editable == 0 && $patient->is_submitted == 0) {

                if(!in_array($preferred_package, ['select', 'confidence'])) {
                    'Enable to submit. Make sure you have completely filled all required sections.';
                }
                $package = 'AL-SECRET-SELECT';
                if($preferred_package == 'confidence') {
                    $package = 'AL-SECRET-CONFIDENCE';
                }
                DB::table('patients')->where('id', $patient->patient_id)->update([
                    "pricing_package" => $package,
                    "setup_type" => $setup_type,
                ]);
            }

            if (!empty($request->advisor) && $request->advisor !== 'null') {
                DB::table('p_treatment_plans')->where('id', $patient->id)->update([
                    "case_holder" => "staff",
                    "previous_case_holder" => "doctor",
                    "status" => "Waiting Staff Review for Advisor",
                    "recommended_advisor" => $advisor_id
                ]);
                $task = (new TaskService($patient->id));
                $task_id = $task->create_task_withoutMail("staff", "Case Review for Advisor", $patient->user_id, $comment, "doctor", "staff", null);
            } else {
                if($patient->is_editable == 0)
                {
                    DB::table('p_treatment_plans')->where('id', $patient->id)->update([
                        "case_holder" => "staff",
                        "previous_case_holder" => "doctor",
                        "status" => "Waiting Staff Review",
                    "recommended_advisor" => $advisor_id
                    ]);


                    $tasks = DB::table('tasks')
                            ->where('treatment_plan_id', $patient->id)
                            // ->where('type','doctor')
                            ->where('status', '!=', 'completed')
                            ->orderByDesc('id')
                            ->get();

                    foreach ($tasks as $task) {
                        DB::table('tasks')->where('id', $task->id)->update([
                            "status" => 'completed',
                            "user_id" => Auth::id(),
                        ]);
                    }
                    $task = (new TaskService($patient->id));
                    $task_id = $task->create_task_withoutMail("staff", "Case Review", 'doctor', null, "doctor", "staff", null);
                }
            }

            if($patient->is_editable == 1)
            {
                DB::table('p_treatment_plans')->where('id', $patient->id)->update([
                    "case_holder" => "staff",
                    "previous_case_holder" => "doctor",
                    "status" => "Waiting Staff Review",
                    "is_editable" => 0,

                ]);


                $tasks = DB::table('tasks')
                        ->where('treatment_plan_id', $patient->id)
                        // ->where('type','doctor')
                        ->where('status', '!=', 'completed')
                        ->orderByDesc('id')
                        ->get();

                foreach ($tasks as $task) {
                    DB::table('tasks')->where('id', $task->id)->update([
                        "status" => 'completed',
                        "user_id" => Auth::id(),
                    ]);
                }
                $task = (new TaskService($patient->id));
                if (!empty($request->advisor) && $request->advisor !== 'null') {
                    $task_id = $task->create_task_withoutMail("staff", "Case Review for Advisor", 'doctor', null, "doctor", "staff", null);
                } else {
                    $task_id = $task->create_task_withoutMail("staff", "Case Review", 'doctor', null, "doctor", "staff", null);
                }


            }

            if ($patient->first_name && $patient->last_name && $patient->dob) {

                $nemotech = new NemoTechService($patient->first_name, $patient->last_name, $patient->dob, $patient->nemotech_patient_id);
                $patient_id = $nemotech->syncPatient();
                if($patient_id != null) {
                    DB::table('patients')->where('id', $patient->patient_id)->update([
                        "nemotech_patient_id" => $patient_id,
                    ]);
                }
                if (($patient->fl_upper_arch && $patient->fl_lower_arch && $patient->fl_front && $patient->fl_smile && $patient->fl_profile && $patient->fl_frontal && $patient->fl_right_buccal && $patient->fl_left_buccal && $patient->fl_upper_occlusal && $patient->fl_lower_occlusal && $patient->fl_panorex && $patient->fl_lateral_ceph ) || $patient->phase!=1) {
                    if (($patient->treat_upper_arch == 1 || $patient->treat_lower_arch == 1) && $patient->is_prescription_submitted == 1) {
                        if ($patient->is_editable == 1) {

                            //sync documents
                            DB::table('sync_queues')->insert([
                                "type" => "Nemotech",
                                "treatment_plan_id" => $phase,
                                "created_at" => date("Y-m-d"),
                            ]);
                            $nemotech->syncDocuments(DB::table('p_treatment_plans as tp')
                            ->where('tp.is_deleted', 0)
                            ->where('tp.id', $phase)
                            ->Join("patients as p", function ($join) {
                                $join->on("tp.patient_id", '=', "p.id")
                                    ->where('p.user_id', Auth::user()->id)
                                    ->where('p.is_deleted', 0);
                            })
                            ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package", "p.nemotech_patient_id")
                            ->first());
                            return redirect('/patient/case-overview/' . $this->hashids->encode($patient->id))->with("success", "Patient Case Edited!");
                        }
                        if (!empty($request->advisor) && $request->advisor !== 'null') {
                            $taskName = 'Case Review for Advisor';
                        } else {
                            $taskName = 'Case Review';
                        }
                        $this->saveOrder($id, $phase, $taskName);

                        //sync documents
                        DB::table('sync_queues')->insert([
                            "type" => "Nemotech",
                            "treatment_plan_id" => $phase,
                            "created_at" => date("Y-m-d"),
                        ]);

                        $nemotech->syncDocuments(DB::table('p_treatment_plans as tp')
                        ->where('tp.is_deleted', 0)
                        ->where('tp.id', $phase)
                        ->Join("patients as p", function ($join) {
                            $join->on("tp.patient_id", '=', "p.id")
                                ->where('p.user_id', Auth::user()->id)
                                ->where('p.is_deleted', 0);
                        })
                        ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package", "p.nemotech_patient_id")
                        ->first());
                        return redirect('/patient/case-overview/' . $this->hashids->encode($patient->id))->with("success", "Patient Case has been added!");
                        //return redirect('/orders/checkout/proceed/' . $id . '/' . $phase . '/initial-deposit');
                    }
                }
            }
        }

        return redirect()->back()->with('error', 'Enable to submit. Make sure you have completely filled all required sections.');
    }
    private function saveOrder($id, $phase, $taskName = null)
    {
        $order_id = @DB::table('orders')->where('treatment_plan_id', $phase)->where('is_deleted', 0)->first()->id;
        // $orderId= DB::table('orders')->where('id', $order_id)->where('is_deleted', 0)->first();
        //$plan= DB::table('p_treatment_plans')->where('id',$orderId->treatment_plan_id)->first();
        if (!@$order_id) {
            $order_id = DB::table('orders')->insertGetId([
                "user_id" => Auth::user()->id,
                "patient_id" => $id,
                "treatment_plan_id" => $phase,
                "datetime" => date("Y-m-d H:i:s"),
                "status" => "pending"
            ]);
        }
        DB::table('p_treatment_plans')->where('id', $phase)->update([
            "is_submitted" => 1,
            "status" => "In Progress",
            "is_editable" => 0,
            "previous_case_holder" => "Doctor",
        ]);


        //add statff tasks
        $tasks = DB::table('tasks')
            ->where('treatment_plan_id', $phase)
            // ->where('type','doctor')
            ->where('status', '!=', 'completed')
            ->orderByDesc('id')
            ->get();

        foreach ($tasks as $task) {
            DB::table('tasks')->where('id', $task->id)->update([
                "status" => 'completed',
                "user_id" => Auth::id(),
            ]);
        }
        $task_id = (new TaskService($phase))->create_task_withoutMail("staff", $taskName != null ? $taskName : "Case Review",    null,            // $user_id
            null,            // $comment
            null,            // $from_role
            null,            // $to_role
            []             // $isMail
        );
    }
    public function validatePatientData(Request $request)
    {
        $id = $request->post('patient_id');
        $phase = $request->post('treatment_plan_id');
        $patient = DB::table('p_treatment_plans as tp')
            ->where('tp.is_deleted', 0)
            //->where('tp.is_submitted', 0)
            ->where('tp.id', $phase)
            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", '=', "p.id")
                    ->where('p.user_id', Auth::user()->id)
                    ->where('p.is_deleted', 0);
            })
            ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package")
            ->first();
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
            if ($patient->phase > 1 || ($patient->fl_front && $patient->fl_smile && $patient->fl_profile && $patient->fl_frontal && $patient->fl_right_buccal && $patient->fl_left_buccal && $patient->fl_upper_occlusal && $patient->fl_lower_occlusal && $patient->fl_panorex && $patient->fl_lateral_ceph)) {
                $fn3 = 1;
            }
            if (($patient->treat_upper_arch == 1 || $patient->treat_lower_arch == 1) && $patient->is_prescription_submitted == 1) {
                $fn4 = 1;
            }
        }
        return response()->json([
            "patient" => $patient,
            "fn1" => $fn1,
            "fn2" => $fn2,
            "fn3" => $fn3,
            "fn4" => $fn4,
        ]);
    }

    public function getOrderList(Request $request)
    {
        $region = $request->input('region');
        $this->setRegion($region);

        $authToken = $this->getValidAuthToken($region);

        $response = Http::withHeaders([
            'X-Auth-Token' => $authToken,
            'X-Auth-AppKey' => config('shining3d.shining3d_app_key'),
            'X-Auth-AppID' => config('shining3d.shining3d_app_id'),
        ])->get($this->baseUrl . '/sdk/dental/order/list', [
            'orgType' => 'lab',
            'orgCode' => config('shining3d.shining3d_orgcode'),
            'page' => 1,
            'pageSize' => 10,
            'startOn' => Carbon::parse($request->input('start_date'))->format('Y-m-d'),
            'endOn' => Carbon::parse($request->input('end_date'))->format('Y-m-d'),
        ]);
        return $response->json();
    }
}
