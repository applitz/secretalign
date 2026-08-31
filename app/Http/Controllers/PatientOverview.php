<?php

namespace App\Http\Controllers;

use App\Http\Services\TaskService;
use App\Http\Services\MailService;
use App\Http\Services\DoctorMailService;
use App\Jobs\DoctorSendToStaffForModificationJob;
use App\Jobs\SendToDoctorFromStaffForApprovalJob;
use App\Jobs\SendToLabForModificationJob;
use App\Jobs\SendToLabFromStaffJob;
use App\Jobs\SendToStaffFromDoctorModificationJob;
use App\Jobs\SentToDoctorForModificatinJob;
use App\Jobs\SubmitTreatmentJob;
use App\Jobs\ApproveCaseByDoctorToStaffJob;
use App\Jobs\CancelTreatmentByLabJob;
use App\Jobs\RejectTreatmentByStaffJob;
use App\Jobs\RequestFilesToLabFromStaffJob;
use App\Jobs\SendToAdvisorFromStaffJob;
use App\Jobs\SubmitFilesJob;
use App\Jobs\SubmitTrackingIdJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Hashids\Hashids;
use App\Models\DoctorClinicalPreference;
use Exception;
use DateTime;
use DateInterval;
use App\Models\User;
use App\Jobs\SendReminderMailJob;
use Carbon\Carbon;
use App\Http\Services\NemoTechService;
use App\Models\Audittrails;
use Illuminate\Support\Str;
use App\Models\TreatmentCheck;

class PatientOverview extends Controller
{
    public $hashids;
    public function __construct()
    {
        $this->middleware('auth');
        $this->hashids = new Hashids();
        View::share("hashids", $this->hashids);
    }

    public function sendApproveMail()
    {
        $comment="<p>Approval</p>";
        $routes = 'dr.secretalign@yopmail.com';
        $first_name = "Test";
        $last_name = "Test Last";
        $attachments = [];
         \Illuminate\Support\Facades\Notification::route('mail', $routes)
                        ->notify(new \App\Notifications\ApproveAlertNew($comment, $attachments, $first_name, $last_name));


    }

    public function fetch_overview(Request $request, $phase)
    {
        $i = true;

        $whereClauses = [["tp.id", $this->hashids->decode($phase)], ["tp.is_deleted", 0],];
        if (Auth::user()->role == 'lab') {
            array_push($whereClauses, ["tp.lab", Auth::user()->id]);
        }
        $advisors = User::where('role', 'advisor')->get();
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
            ->select("tp.*", "p.pricing_package", "p.first_name", "p.last_name", "p.dob", "p.user_id", "l.first_name as lab_first_name", "l.last_name as lab_last_name")
            ->first();
        if (@$patient) {
            $data = compact("patient");
            $comments = DB::table('comments as c')
                ->where('c.treatment_plan_id', $patient->id)
                ->leftJoin("users as u", function ($join) {
                    $join->on("c.added_by", "=", "u.id");
                })
                ->select("c.*", "u.first_name", "u.last_name")
                ->orderByDesc('id')
                ->paginate(10);
            $labs = DB::table('users')->where('role', 'lab')->get();
            $plans = DB::table('p_treatment_plans')->where('is_deleted', 0)->where('patient_id', $patient->patient_id)->orderByDesc('phase')->select("phase", "id")->get();

            $data = compact("patient", "labs", "comments", "plans", "i", "advisors");

            $notificationId = @$request->get('notify');
            if (!empty($notificationId)) {
                if (DB::table('notifications')->where('treatment_plan_id', $phase)->where('user_id', Auth::user()->id)->where('id', $notificationId)->whereNull('read_at')->exists()) {
                    DB::table('notifications')->where('id', $notificationId)->update([
                        "read_at" => date("Y-m-d H:i:s"),
                    ]);
                }
            }

            // Fetch doctor's clinical preferences
            $clinicalPreference = DoctorClinicalPreference::where('doctor_id', $patient->user_id)->first();
            $data['clinicalPreference'] = $clinicalPreference;
            return View::make("patients.case_overview_el", $data);
        }
    }
    public function overview(Request $request, $phase)
    {
        $whereClauses = [["tp.id", $this->hashids->decode($phase)], ["tp.is_deleted", 0],];

        if (Auth::user()->role == 'lab') {
            array_push($whereClauses, ["tp.lab", Auth::user()->id]);
        }

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
        if (@$patient) {
            $data = compact("patient");
            $comments = DB::table('comments as c')
                ->where('c.treatment_plan_id', $patient->id)
                ->leftJoin("users as u", function ($join) {
                    $join->on("c.added_by", "=", "u.id");
                })
                ->select("c.*", "u.first_name", "u.last_name")
                ->orderByDesc('c.id')
                ->get();

            $labs = DB::table('users')->where('role', 'lab')->get();
            $advisors = DB::table('users')->where('role', 'advisor')->get();
            // dd($advisors);
            $plans = DB::table('p_treatment_plans')->where('is_deleted', 0)->where('patient_id', $patient->patient_id)->orderByDesc('phase')->select("phase", "id")->get();
            $treatmentCheck = TreatmentCheck::where('patient_id', $patient->id)->first();

            // Fetch doctor's clinical preferences
            $clinicalPreference = DoctorClinicalPreference::where('doctor_id', $patient->user_id)->first();

            $data = compact("patient", "labs", "comments", "plans", "advisors","treatmentCheck", "clinicalPreference");
            $data['stl_files'] = [];
            $notificationId = @$request->get('notify');
            Log::info(json_encode($data));
            if (!empty($notificationId)) {
                if (DB::table('notifications')->where('treatment_plan_id', $phase)->where('user_id', Auth::user()->id)->where('id', $notificationId)->whereNull('read_at')->exists()) {
                    DB::table('notifications')->where('id', $notificationId)->update([
                        "read_at" => date("Y-m-d H:i:s"),
                    ]);
                }
            }
            if ($data['patient']->treatment_link && $data['patient']->treatment_link !== '' && $data['patient']->treatment_link !== 'null') {
                $data['stl_files'] = listPublicDriveFiles($data['patient']->treatment_link);
            }
            $data['role'] = Auth::user()->role;
            return view("patients.case_overview", $data);
        }
        abort(403, 'Unauthorized request!');
    }



    public function iframe(Request $request, $phase)
    {

        $whereClauses = [["tp.id", $this->hashids->decode($phase)], ["tp.is_deleted", 0],];

        if (Auth::user()->role == 'lab') {
            array_push($whereClauses, ["tp.lab", Auth::user()->id]);
        }
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
            ->select("tp.*", "p.pricing_package", "p.first_name", "p.last_name", "p.dob", "p.user_id", "l.first_name as lab_first_name", "l.last_name as lab_last_name")
            ->first();
        if (@$patient) {
            $data = compact("patient");
            $comments = DB::table('comments as c')
                ->where('c.treatment_plan_id', $patient->id)
                ->leftJoin("users as u", function ($join) {
                    $join->on("c.added_by", "=", "u.id");
                })
                ->select("c.*", "u.first_name", "u.last_name")
                ->orderByDesc('c.id')
                ->get();

            $labs = DB::table('users')->where('role', 'lab')->get();
            $plans = DB::table('p_treatment_plans')->where('is_deleted', 0)->where('patient_id', $patient->patient_id)->orderByDesc('phase')->select("phase", "id")->get();

            // Fetch doctor's clinical preferences
            $clinicalPreference = DoctorClinicalPreference::where('doctor_id', $patient->user_id)->first();

            $data = compact("patient", "labs", "comments", "plans");
            $notificationId = @$request->get('notify');
            if (!empty($notificationId)) {
                if (DB::table('notifications')->where('treatment_plan_id', $phase)->where('user_id', Auth::user()->id)->where('id', $notificationId)->whereNull('read_at')->exists()) {
                    DB::table('notifications')->where('id', $notificationId)->update([
                        "read_at" => date("Y-m-d H:i:s"),
                    ]);
                }
            }
            return view("patients.case_iframe", $data);
        }
        abort(403, 'Unauthorized request!');
    }
    public function iframeLinkOptional (Request $request, $phase)
    {

        $whereClauses = [["tp.id", $this->hashids->decode($phase)], ["tp.is_deleted", 0],];

        if (Auth::user()->role == 'lab') {
            array_push($whereClauses, ["tp.lab", Auth::user()->id]);
        }
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
            ->select("tp.*", "p.pricing_package", "p.first_name", "p.last_name", "p.dob", "p.user_id", "l.first_name as lab_first_name", "l.last_name as lab_last_name")
            ->first();
        if (@$patient) {
            $data = compact("patient");
            $comments = DB::table('comments as c')
                ->where('c.treatment_plan_id', $patient->id)
                ->leftJoin("users as u", function ($join) {
                    $join->on("c.added_by", "=", "u.id");
                })
                ->select("c.*", "u.first_name", "u.last_name")
                ->orderByDesc('c.id')
                ->get();

            $labs = DB::table('users')->where('role', 'lab')->get();
            $plans = DB::table('p_treatment_plans')->where('is_deleted', 0)->where('patient_id', $patient->patient_id)->orderByDesc('phase')->select("phase", "id")->get();

            // Fetch doctor's clinical preferences
            $clinicalPreference = DoctorClinicalPreference::where('doctor_id', $patient->user_id)->first();

            $data = compact("patient", "labs", "comments", "plans");
            $notificationId = @$request->get('notify');
            if (!empty($notificationId)) {
                if (DB::table('notifications')->where('treatment_plan_id', $phase)->where('user_id', Auth::user()->id)->where('id', $notificationId)->whereNull('read_at')->exists()) {
                    DB::table('notifications')->where('id', $notificationId)->update([
                        "read_at" => date("Y-m-d H:i:s"),
                    ]);
                }
            }
            return view("patients.case_iframe_optional", $data);
        }
        abort(403, 'Unauthorized request!');
    }
    public function get_overview_comments(Request $request, $treatment_plan_id)
    {

        $comments = DB::table('comments as c')
            ->where('c.treatment_plan_id', $treatment_plan_id)
            ->leftJoin("users as u", function ($join) {
                $join->on("c.added_by", "=", "u.id");
            })
            ->select("c.*", "u.first_name", "u.last_name")
            ->orderByDesc('c.id')
            ->paginate(10);

        return view("patients.overview_comments", compact("comments"))->render();
    }
    public function submit_to_lab_for_treatment(Request $request)
    {
        if (Auth::user()->role == 'staff') {

            $data = $request->all();
            unset(
                $data['attachments']
            );
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $lab = $request->post('lab');
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    // $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                    $data['attachments'][] = $filename;
                }
            }
            $attachments = implode(',', $attachments);
            if (DB::table('users')->where('id', $lab)->where('role', 'lab')->exists()) {

                // $treatment_plan = DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->first();
                $treatment_plan = DB::table('p_treatment_plans as tp')
                                    ->where('tp.id', $treatment_plan_id)
                                    ->Join("patients as p", function ($join) {
                                        $join->on("tp.patient_id", "=", "p.id")
                                            ->where("p.is_deleted", 0);
                                    })
                                    ->select("tp.*", "p.first_name", "p.last_name", "p.user_id", "p.pricing_package", "p.id as patientsId")
                                    ->first();


                if (@$treatment_plan->case_holder == 'staff') {

                    $lab_details = DB::table('users')->where('id', $lab)->where('role', 'lab')->select('first_name', 'last_name', 'email')->first();

                    $details = [
                        'subject' => 'Action Required: New Case Assigned for Patient ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                        'title' => 'Action Required: New Case Assigned for Patient ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                        'patient_name' => $treatment_plan->first_name." " . $treatment_plan->last_name,
                        'comment' => $comment,
                        'lab_name' => $lab_details->first_name." " . $lab_details->last_name,
                        'lab_email' => $lab_details->email,
                        'attachments' => $attachments,
                    ];

                    SendToLabFromStaffJob::dispatch($details);

                    //if phase greater than 1 do not change lab
                    // if ($treatment_plan->phase > 1) {
                    //     $lab = $treatment_plan->lab;
                    // }
                    $task = new TaskService($treatment_plan_id);
                    $task->complete_task("staff"); // complete staff task
                    //add lab task + lab request
                    if ($treatment_plan->is_continue == 1 || $treatment_plan->is_completed == 1) {
                        $task_id = $task->create_task("lab", "Production", $lab, $comment, "staff", "lab", $attachments); //comment from staff to lab
                    } else {
                        $task_id = $task->create_task("lab", "Setup " . $treatment_plan->phase, $lab, $comment, "staff", "lab", $attachments); //comment from staff to lab
                    }
                    if ($task_id != false) {
                        //add lab request
                        if ($treatment_plan->is_treatment_submitted == 0 && $treatment_plan->is_sent_to_lab == 0) {
                            DB::table('lab_requests')->insert([
                                "treatment_plan_id" => $treatment_plan->id,
                                "user_id" => $lab,
                                "task_id" => $task_id,
                            ]);
                        }
                        //sent to lab
                        DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                            "is_sent_to_lab" => 1,
                            "is_lab_cancel" => 0,
                            "case_holder" => "lab",
                            "previous_case_holder" => "staff",
                            "status" => "Waiting Lab Review",
                            "lab" => $lab,
                            "is_editable" => 0,
                        ]);

                        $order_id = @DB::table('orders')->where('treatment_plan_id', $treatment_plan_id)->where('is_deleted', 0)->first()->id;
                        if (@$order_id) {
                            DB::table('orders')->where('id', $order_id)->update([
                                "status" => 'processing',
                            ]);
                        }
                    }
                }
            }

            unset(
                $data['_token'],
                $data['treatment_plan_id'],
            );
            $objAudittrails = new Audittrails();
            $saveAudittrails = $objAudittrails->addAudittrails($treatment_plan->patientsId, $request->post('treatment_plan_id'), "Staff Send Case to Lab", 'S', 'L', $data);
        }
    }
    public function request_modification(Request $request) //request modification from lab
    {
        if (Auth::user()->role == 'staff') {
            $data = $request->all();
            unset(
                $data['attachments']
            );
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.user_id", "p.first_name", "p.last_name", "p.setup_type", "p.id as patientsId")
                ->first();
            // dd($treatment_plan);
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    // $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                    $data['attachments'][] = $filename;
                }
            }
            $attachments = implode(',', $attachments);

            if (@$treatment_plan->case_holder == 'staff') {

                if ($treatment_plan->is_sent_to_lab == 1 && $treatment_plan->is_treatment_submitted == 1 && $treatment_plan->lab != null && $treatment_plan->lab != '') {
                    $lab_details = DB::table('users')->where('id', $treatment_plan->lab)->where('role', 'lab')->select('first_name', 'last_name', 'email')->first();
                    $details = [
                        'subject' => 'Action Required: '. Auth::user()->first_name. ' ' . Auth::user()->last_name . ' requested modification for Patient ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                        'title' => 'Action Required: '. Auth::user()->first_name. ' ' . Auth::user()->last_name . ' requested modification for Patient ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                        'patient_name' => $treatment_plan->first_name." " . $treatment_plan->last_name,
                        'comment' => $comment,
                        'lab_name' => $lab_details->first_name." " . $lab_details->last_name,
                        'lab_email' => $lab_details->email,
                        'attachments' => $attachments,
                    ];

                    SendToLabForModificationJob::dispatch($details);
                    $task = new TaskService($treatment_plan_id);
                    $task->complete_task("staff");
                    if ($treatment_plan->is_continue == 1 || $treatment_plan->is_completed == 1) {
                        $task_id = $task->create_task("lab", "Production", $treatment_plan->lab, $comment, "staff", "lab", $attachments); //comment from staff to lab
                    } else {
                        $task_id = $task->create_task("lab", "Modification " . $treatment_plan->phase, $treatment_plan->lab, $comment, "staff", "lab", $attachments); //comment from staff to lab
                    }
                    $routes = DB::table('users')->where('id', Auth::id())->pluck("email")->toArray();

                    if ($task_id) {
                        DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                            "is_sent_to_lab" => 1,
                            "is_lab_cancel" => 0,
                            "is_treatment_submitted" => 0,
                            "dr_request_modification" => false,
                            "case_holder" => "lab",
                            "previous_case_holder" => "staff",
                            "status" => "Waiting Lab Review",
                        ]);
                    }
                    unset(
                        $data['_token'],
                        $data['treatment_plan_id'],
                    );
                    $objAudittrails = new AuditTrails();
                    $saveAudittrails = $objAudittrails->addAudittrails( $treatment_plan->patientsId, $request->post('treatment_plan_id'), "Sent to Lab for Modification by Staff", 'S', 'L', $data);
                }
            }
        }
    }

    public function request_modification_quick_setup(Request $request) //request modification from lab
    {
        if (Auth::user()->role == 'staff') {
            $data = $request->all();
            unset(
                $data['attachments'],
            );
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.user_id", "p.first_name", "p.last_name", "p.setup_type", "p.is_setup_type_approved", "p.id as patientsId")
                ->first();


            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    // $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                }
            }
            $attachments = implode(',', $attachments);

            if (@$treatment_plan->case_holder == 'staff') {

                if ($treatment_plan->is_sent_to_lab == 1 && $treatment_plan->is_treatment_submitted == 1 && $treatment_plan->lab != null && $treatment_plan->lab != '') {
                    $lab_details = DB::table('users')->where('id', $treatment_plan->lab)->where('role', 'lab')->select('first_name', 'last_name', 'email')->first();
                    $details = [
                        'subject' => 'Action Required: '. Auth::user()->first_name. ' ' . Auth::user()->last_name . ' Approved Quick Setup for Patient ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                        'title' => 'Action Required: '. Auth::user()->first_name. ' ' . Auth::user()->last_name . ' Approved Quick Setup for Patient ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                        'patient_name' => $treatment_plan->first_name." " . $treatment_plan->last_name,
                        'comment' => $comment,
                        'lab_name' => $lab_details->first_name." " . $lab_details->last_name,
                        'lab_email' => $lab_details->email,
                        'attachments' => $attachments,
                    ];

                    SendToLabForModificationJob::dispatch($details);
                    $task = new TaskService($treatment_plan_id);
                    $task->complete_task("staff");
                    if ($treatment_plan->is_continue == 1 || $treatment_plan->is_completed == 1) {
                        $task_id = $task->create_task("lab", "Production", $treatment_plan->lab, $comment, "staff", "lab", $attachments); //comment from staff to lab
                    } else {
                        $task_id = $task->create_task("lab", "Quick Setup Approved", $treatment_plan->lab, $comment, "staff", "lab", $attachments); //comment from staff to lab
                    }
                    $routes = DB::table('users')->where('id', Auth::id())->pluck("email")->toArray();

                    if ($task_id) {
                        DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                            "is_sent_to_lab" => 1,
                            "is_lab_cancel" => 0,
                            "is_treatment_submitted" => 0,
                            "dr_request_modification" => false,
                            "case_holder" => "lab",
                            "previous_case_holder" => "staff",
                            "status" => "Quick Setup Approved",
                        ]);
                    }
                    unset(
                        $data['_token'],
                        $data['treatment_plan_id'],
                    );
                    $objAudittrails = new AuditTrails();
                    $saveAudittrails = $objAudittrails->addAudittrails( $treatment_plan->patientsId, $request->post('treatment_plan_id'), "Sent to Lab for Modification by Staff", 'S', 'L', $data);
                }
            }
        }
    }
    // Done By Parth
    public function send_from_staff_to_lab(Request $request)
    {
        if (Auth::user()->role == 'staff') {
            $data = $request->all();

            unset(
                $data['attachments'],
            );

            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');

            $lab = $request->post('lab');

            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    // $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                    $data['attachments'][] = $filename;
                }
            }
            $attachments = implode(',', $attachments);
             $treatment_plan = DB::table('p_treatment_plans as tp')
                                    ->where('tp.id', $treatment_plan_id)
                                    ->Join("patients as p", function ($join) {
                                        $join->on("tp.patient_id", "=", "p.id")
                                            ->where("p.is_deleted", 0);
                                    })
                                    ->select("tp.*", "p.first_name", "p.last_name", "p.user_id", "p.pricing_package", "p.id as patientsId")
                                    ->first();

            if ($lab == null) {
                $lab = $treatment_plan->lab;
            }
            if (@$treatment_plan->case_holder == 'staff') {

                $lab = DB::table('lab_requests')->where('treatment_plan_id', $treatment_plan->id)->where('is_canceled', 0)->orderByDesc('id')->first();
                $lab_details = DB::table('users')->where('id', $lab->user_id)->where('role', 'lab')->select('first_name', 'last_name', 'email')->first();


                if (@$lab) {
                    $task = new TaskService($treatment_plan_id);
                    $task->complete_task("staff");
                    //add lab task + lab request
                    if ($treatment_plan->is_continue == 1 || $treatment_plan->is_completed == 1) {
                        $task_id = $task->create_task("lab", "Production ". $treatment_plan->phase, $lab->user_id, $comment, "staff", "lab", $attachments); //comment from staff to lab
                    } else {
                        $task_id = $task->create_task("lab", "Setup " . $treatment_plan->phase, $lab->user_id, $comment, "staff", "lab", $attachments); //comment from staff to lab
                    }

                    if ($task_id != false) {
                        //sent to lab
                        DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                            "is_sent_to_lab" => 1,
                            "is_lab_cancel" => 0,
                            "case_holder" => "lab",
                            "previous_case_holder" => "staff",
                            "status" => "Treatment Plan Approved",
                            "is_editable" => 0,
                        ]);
                    }
                } elseif ($treatment_plan->is_continue && $lab != null) {
                    $task = new TaskService($treatment_plan_id);
                    $task->complete_task("staff");
                    //add lab task + lab request
                    if ($$treatment_plan->is_continue == 1) {
                        $task_id = $task->create_task("lab", "Production " . $treatment_plan->phase, $lab->user_id, $comment, "staff", "lab", $attachments); //comment from staff to lab/comment from lab to staff
                    } else {
                        $task_id = $task->create_task("lab", "Setup " . $treatment_plan->phase, $lab->user_id, $comment, "staff", "lab", $attachments); //comment from staff to lab
                    }

                    if ($task_id != false) {
                        //sent to lab
                        DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                            "is_sent_to_lab" => 1,
                            "is_lab_cancel" => 0,
                            "case_holder" => "lab",
                            "previous_case_holder" => "staff",
                            "status" => "Treatment Plan Approved",
                            "is_editable" => 0,
                        ]);
                    }
                }

                $details = [
                    'subject' => 'Action Required: ' . Auth::user()->first_name . ' ' . Auth::user()->last_name .' has requested files for Patient ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'title' => 'Action Required: ' . Auth::user()->first_name . ' ' . Auth::user()->last_name .' has requested files for Patient ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'patient_name' => $treatment_plan->first_name." " . $treatment_plan->last_name,
                    'comment' => $comment,
                    'lab_name' => $lab_details->first_name." " . $lab_details->last_name,
                    'lab_email' => $lab_details->email,
                    'attachments' => $attachments,
                ];
                RequestFilesToLabFromStaffJob::dispatch($details);

                $data = $request->all();
                unset(
                    $data['_token'],
                    $data['treatment_plan_id'],
                );

                $objAudittrails = new AuditTrails();
                $saveAudittrails = $objAudittrails->addAudittrails( $treatment_plan->patientsId, $request->post('treatment_plan_id'), "Staff Sent the Case to the Lab for File Request", 'S', 'L', $data);
            }
        }
    }
    public function send_from_lab_to_staff(Request $request)
    {
        if (Auth::user()->role == 'lab') {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    // $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                }
            }
            $attachments = implode(',', $attachments);
            $treatment_plan = DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->first();
            if (@$treatment_plan->case_holder == 'lab') {
                $task = (new TaskService($treatment_plan_id));
                $task->complete_task("lab"); //complete lab task;
                $task->complete_task("staff"); //complete staff's task
                if ($treatment_plan->is_continue == 1) {
                    $task_id = $task->create_task("staff", 'Production', null, $comment, "lab", "staff", $attachments); //comment from lab to staff
                } else {
                    $task_id = $task->create_task("staff", 'Review Setup', null, $comment, "lab", "staff", $attachments);
                }

                if ($task_id != false) {
                    DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                        "case_holder" => "staff",
                        "previous_case_holder" => "lab",
                        "status" => "Waiting Staff Review",
                    ]);
                }
            }
        }
    }
    public function submit_treatment(Request $request)
    {
        $data = $request->all();
        unset(
            $data['attachments'],
        );
        if (Auth::user()->role !== 'lab') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'treatment_link' => 'nullable|string',
            'treatment_plan_id' => 'required|integer|exists:p_treatment_plans,id',
            'comment' => 'nullable|string',
            'patient_link' => 'nullable|string',
            'iframe_link' => 'nullable|string',
            'iframe_link_optional' => 'nullable|string',
            'attachments.*' => 'file|max:5120', // Max 5MB per file
        ]);

        $treatment_link = $request->post('treatment_link');
        if ($treatment_link) {
            if (!isGoogleDriveLink($treatment_link)) {
                return response()->json(['error' => 'The treatment link must be a valid Google Drive link.'], 400);
            } elseif (!checkTreatmentLinkIsPublicOrNot($treatment_link)) {
                return response()->json(['error' => 'The treatment link must be a public link.'], 400);
            }
        }

        $treatment_plan_id = $request->post('treatment_plan_id');
        $comment = $request->post('comment');
        $patient_link = $request->post('patient_link');
        $iframe_link = $request->post('iframe_link');
        $iframe_link_optional = $request->post('iframe_link_optional');
        $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.user_id", "p.pricing_package", "p.id as patientsId", "p.is_setup_type_approved", "p.setup_type")
                ->first();

        if($treatment_plan->patient_link != $patient_link || $treatment_plan->iframe_link != $iframe_link){
            $is_link_updated = 1;
        }else {
            $is_link_updated = 0;
        }
        if (!$treatment_plan) {
            return response()->json(['error' => 'Treatment plan not found.'], 404);
        }

        // Upload attachments
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/attachments', $filename);
                $attachments[] = $filename;
                $data['attachments'][] = $filename;
            }
        }

        $attachments_str = implode(',', $attachments);

        // Check if case holder is 'lab'
        if ($treatment_plan->case_holder === 'lab') {
            $labName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            $details = [
                'subject' => 'Action Required: Treatment Plan Submitted by ' . $labName . ' for Patient: ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                'title' => 'Action Required: Treatment Plan Submitted by ' . $labName . ' for Patient: ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                'patient_name' => $treatment_plan->first_name." " . $treatment_plan->last_name,
                'comment' => $comment,
                'patient_link' => $patient_link,
                'iframe_link' => $iframe_link,
                'iframe_link_optional' => $iframe_link_optional,
                'attachments' => $attachments_str,
                'lab_name' => $labName,
            ];

            $staff = DB::table('users')
                        ->where('role', 'staff')
                        ->get(['first_name', 'last_name', 'email'])
                        ->toArray();

            SubmitTreatmentJob::dispatch($staff, $details);

            $task = new TaskService($treatment_plan_id);
            $task->complete_task("lab");
            $task->complete_task("staff");

            $title = 'Review Setup '.$treatment_plan->phase;
            if ($treatment_plan->is_continue == 1 || $treatment_plan->is_completed == 1) {
                $title = 'Production';
            } elseif ($treatment_plan->is_completed == 1) {
                $title = 'Download Setup Files';
            }

            $task_id = $task->create_task("staff", $title, null, $comment, "lab", "staff", $attachments_str);

            if ($task_id) {
                DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
                    "case_holder" => "staff",
                    "previous_case_holder" => "lab",
                    "treatment_link" => $treatment_link,
                    "iframe_link" => $iframe_link,
                    'iframe_link_optional' => $iframe_link_optional,
                    "patient_link" => $patient_link,
                    "is_treatment_submitted" => 1,
                    "is_link_updated" => $is_link_updated,
                    "is_lab_cancel" => 0,
                    "status" => "Treatment Plan Completed",
                ]);
                // $data = $request->all();
                unset(
                    $data['_token'],
                    $data['treatment_plan_id'],
                );

                $objAudittrails = new AuditTrails();
                $saveAudittrails = $objAudittrails->addAudittrails( $treatment_plan->patientsId, $request->post('treatment_plan_id'), "Lab Submit Treatment", 'L', 'S', $data);
                return response()->json(['message' => 'Treatment submitted successfully.'], 200);
            } else {
                return response()->json(['error' => 'Failed to assign task to staff.'], 500);
            }
        }

        return response()->json(['error' => 'Invalid treatment plan state.'], 400);
    }

    public function submit_files(Request $request)
    {
        if (Auth::user()->role !== 'lab') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $data = $request->all();
        unset(
            $data['attachments'],
        );

        $request->validate([
            'treatment_link' => 'nullable|string',
            'treatment_plan_id' => 'required|integer|exists:p_treatment_plans,id',
            'comment' => 'nullable|string',
            'patient_link' => 'nullable|string',
            'iframe_link' => 'nullable|string',
            'attachments.*' => 'file|max:5120', // Max 5MB per file
        ]);

        $treatment_link = $request->post('treatment_link');
        if ($treatment_link) {
            if (!isGoogleDriveLink($treatment_link)) {
                return response()->json(['error' => 'The treatment link must be a valid Google Drive link.'], 400);
            } elseif (!checkTreatmentLinkIsPublicOrNot($treatment_link)) {
                return response()->json(['error' => 'The treatment link must be a public link.'], 400);
            }
        }

        $treatment_plan_id = $request->post('treatment_plan_id');
        $comment = $request->post('comment');
        $patient_link = $request->post('patient_link');
        $iframe_link = $request->post('iframe_link');

         $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.user_id", "p.pricing_package", "p.id as patientsId")
                ->first();


        if (!$treatment_plan) {
            return response()->json(['error' => 'Treatment plan not found.'], 404);
        }

        // Upload attachments
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/attachments', $filename);
                $attachments[] = $filename;
                $data['attachments'][] = $filename;
            }
        }

        $attachments_str = implode(',', $attachments);
        // Check if case holder is 'lab'
        if ($treatment_plan->case_holder === 'lab') {
            $task = new TaskService($treatment_plan_id);
            $task->complete_task("lab");
            $task->complete_task("staff");

            $title = 'Production '.$treatment_plan->phase;

            $task_id = $task->create_task("staff", $title, null, $comment, "lab", "staff", $attachments_str);
            $details = [
                'subject' => 'Action Required: '. Auth::user()->first_name . ' ' . Auth::user()->last_name .' has submitted a files link for Patient ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                'title' => 'Action Required: '. Auth::user()->first_name . ' ' . Auth::user()->last_name .' has submitted a files link for Patient ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                'patient_name' => $treatment_plan->first_name." " . $treatment_plan->last_name,
                'patient_link' => $patient_link,
                'lab_name' => Auth::user()->first_name . ' ' . Auth::user()->last_name ,
                'iframe_link' => $iframe_link,
                'treatment_link' => $treatment_link,
                'comment' => $comment,
                'attachments' => $attachments,
            ];

            $staff = DB::table('users')
                    ->where('role', 'staff')
                    ->get(['first_name', 'last_name', 'email'])
                    ->toArray();

            SubmitFilesJob::dispatch($staff, $details);

            if ($task_id) {
                DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
                    "case_holder" => "staff",
                    "previous_case_holder" => "lab",
                    "treatment_link" => $treatment_link,
                    "iframe_link" => $iframe_link,
                    "patient_link" => $patient_link,
                    "is_treatment_submitted" => 1,
                    "status" => "Production",
                ]);
                unset(
                    $data['_token'],
                    $data['treatment_plan_id'],
                );

                $objAudittrails = new AuditTrails();
                $saveAudittrails = $objAudittrails->addAudittrails( $treatment_plan->patientsId, $request->post('treatment_plan_id'), "Lab Submitted the Required Files", 'L', 'S', $data);
                return response()->json(['message' => 'Treatment submitted successfully.'], 200);
            } else {
                return response()->json(['error' => 'Failed to assign task to staff.'], 500);
            }
        }

        return response()->json(['error' => 'Invalid treatment plan state.'], 400);
    }

    public function submit_treatment_old(Request $request)
    {
        if (Auth::user()->role == 'lab') {
            $treatment_link = $request->post('treatment_link');
            if (!isGoogleDriveLink($treatment_link)) {
                return response()->json(['error' => 'The treatment link must be a valid Google Drive link.'], 400);
            } else if (!checkTreatmentLinkIsPublicOrNot($treatment_link)) {
                return response()->json(['error' => 'The treatment link must be a public link.'], 400);
            }
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $patient_link = $request->post('patient_link');
            $iframe_link = @$request->post('iframe_link');
            $treatment_plan = DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->first();
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    // $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')

                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                }
            }
            $attachments = implode(',', $attachments);
            if (@$treatment_plan->case_holder == 'lab') {
                $task = (new TaskService($treatment_plan_id));
                $task->complete_task("lab"); //complete lab task
                $task->complete_task("staff"); //complete staff's task
                //add staff task
                if ($treatment_plan->is_completed == 1) {
                    $title = 'Download Setup Files';
                } else {
                    $title = 'Review Setup';
                }
                if ($treatment_plan->is_continue == 1 || $treatment_plan->is_completed == 1) {
                    $title = 'Production';
                } else {
                    $title = 'Review Setup';
                }
                $task_id = $task->create_task("staff", $title, null, $comment, "lab", "staff", $attachments);

                if ($task_id != null) {
                    DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                        "case_holder" => "staff",
                        "previous_case_holder" => "lab",
                        "treatment_link" => $treatment_link,
                        "iframe_link" => $iframe_link,
                        "patient_link" => $patient_link,
                        "is_treatment_submitted" => 1,
                        "status" => "Treatment Plan Completed",
                    ]);
                }
            }
        }
        //return reir
    }
    public function submit_setup_files(Request $request)
    {
        if (Auth::user()->role == 'lab') {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $setup_files_link = $request->post('setup_files_link');

            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    // $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                }
            }
            $attachments = implode(',', $attachments);


            $treatment_plan = DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->first();
            if (@$treatment_plan->case_holder == 'lab') {
                $task = (new TaskService($treatment_plan_id));
                $task->complete_task("lab"); //complete lab task
                $task->complete_task("staff"); //complete staff's task
                //add staff task
                $task_id = $task->create_task("staff", "Download Setup Files", null, $comment, "lab", "staff", $attachments); //comment from lab to staff
                if ($task_id != false) {
                    DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                        "case_holder" => "staff",
                        "previous_case_holder" => "lab",
                        "treatment_link" => $setup_files_link,
                    ]);
                }
            }
        }
    }

    public function submit_tracking_id(Request $request)
    {
        if (Auth::user()->role == 'staff') {
            $data = $request->all();
            unset(
                $data['attachments'],
            );
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $tracking_id = ($request->post('tracking_id'));
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.user_id", "p.pricing_package", "p.id as patientsId",  "p.first_name as p_first_name", "p.last_name as p_last_name")
                ->first();
            $tasks = DB::table('tasks')
                ->where('treatment_plan_id', $treatment_plan_id)
                ->where('type', 'staff')
                ->where('status', '!=', 'completed')
                ->orderByDesc('id')
                ->get();

            foreach ($tasks as $task) {
                DB::table('tasks')->where('id', $task->id)->update([
                    "status" => 'completed',
                    "user_id" => Auth::id(),
                ]);
            }
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    //  $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                    $data['attachments'][] = $filename;
                }
            }
            $attachments = implode(',', $attachments);

            if (@$treatment_plan->case_holder == 'staff') {



                DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                    "tracking_id" => $tracking_id,
                    "shipping_date_time" => date("Y-m-d H:i:s"),
                    "case_holder" => 'doctor',
                    'previous_case_holder' => 'staff',
                    'status' => 'Shipped',
                    'expiry_date' => getExpriyDateForNewPlaFromTreatmentPlanId($treatment_plan->id, date("Y-m-d H:i:s")),
                    'is_completed' => 1,
                ]);

                // $task_service = (new TaskService($treatment_plan_id));
                // $task_id = $task_service->sendMail($treatment_plan_id,"doctor", "Review Tracking Nr." . $treatment_plan->phase, $treatment_plan->user_id, $comment, "staff", "doctor",$attachments); //comment from staff to lab


                $lab_routes = DB::table('users')->where('id', $treatment_plan->user_id)->pluck("email")->toArray();
                $patient_id = $treatment_plan->patient_id;
                $doctor_id = DB::table('patients')->where('id', $patient_id)->first();
                $doctorDetails = DB::table('users')->where('id', $doctor_id->user_id)->select('email', 'first_name', 'last_name')->get()->toArray();
                $lab_routes = $doctorDetails[0]->email;
                $details = [
                    'subject' => 'Action Required: Tracking Number Submitted for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'title' => 'Action Required: Tracking Number Submitted for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'tracking_id' => $tracking_id,
                    'doctor_name' => $doctorDetails[0]->first_name." ".$doctorDetails[0]->last_name,
                    'patient_name' => $treatment_plan->first_name." ".$treatment_plan->last_name,
                    'comment' => $comment,
                    'attachments' => $attachments,
                    'email' => $lab_routes,
                ];
                SubmitTrackingIdJob::dispatch($details);
                $task_id = (new TaskService($treatment_plan_id));

                // if(!@$treatment_plan->tracking_id) {
                //     $task->complete_task("staff"); //complete staff task
                // }
                $tasks = DB::table('tasks')
                    ->where('treatment_plan_id', $treatment_plan_id)
                    ->where('type', 'staff')
                    ->where('status', '!=', 'completed')
                    ->orderByDesc('id')
                    ->get();

                foreach ($tasks as $task) {
                    DB::table('tasks')->where('id', $task->id)->update([
                        "status" => 'completed',
                        "user_id" => Auth::id(),
                    ]);
                }
                //    $task_id = $task->create_task("doctor", "Review Tracking Nr." . $treatment_plan->phase, $treatment_plan->user_id, $comment, "staff", "doctor",$attachments); //comment from staff to lab
                $task_id = DB::table('tasks')->where('treatment_plan_id', $treatment_plan->id)->orderBy('id', 'desc')->first();
                if ($request->hasFile('attachments') != null || $request->post('comment') != null) {
                    DB::table('comments')->insert([
                        "treatment_plan_id" => $treatment_plan_id,
                        "task_id" => $task_id->id,
                        "added_by" => Auth::user()->id,
                        "from_role" => 'staff',
                        "to_role" => 'doctor',
                        "comment" => $comment,
                        'attachments' => $attachments,
                        "created_at" => now()
                    ]);
                }
                DB::table('notifications')->insert([
                    "title" => "Tracking Nr.",
                    "user_id" => $treatment_plan->user_id,
                    "type" => "doctor",
                    "body" => "View Tracking Nr. for " . $treatment_plan->p_last_name . "' Treatment Plan " . $treatment_plan->phase,
                    "treatment_plan_id" => $treatment_plan->id,
                ]);

                unset(
                    $data['_token'],
                    $data['treatment_plan_id'],
                );

                $objAudittrails = new AuditTrails();
                $saveAudittrails = $objAudittrails->addAudittrails( $treatment_plan->patientsId, $request->post('treatment_plan_id'), "Staff Submitted Tracking ID", 'S', 'D', $data);
                return response()->json(["status" => 200]);
            } elseif ((@$treatment_plan->case_holder == 'staff' && @$treatment_plan->is_continue == 1)) {
                DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                    "tracking_id" => $tracking_id,
                    "shipping_date_time" => date("Y-m-d H:i:s"),
                    "case_holder" => 'doctor',
                    'previous_case_holder' => 'staff',
                    'is_completed' => 1,
                    'status' => 'Shipped',
                    'expiry_date' => getExpriyDateForNewPlaFromTreatmentPlanId($treatment_plan->id, date("Y-m-d H:i:s")),
                ]);
                $task_service = (new TaskService($treatment_plan_id));
                // $task_id = $task_service->create_task_withoutMail("doctor", "Review Tracking Nr." . $treatment_plan->phase, $treatment_plan->user_id, $comment, "staff", "doctor", $attachments); //comment from staff to lab
                $lab_routes = DB::table('users')->where('id', $treatment_plan->user_id)->pluck("email")->toArray();
                $patient_id = $treatment_plan->patient_id;
                $doctor_id = DB::table('patients')->where('id', $patient_id)->first();
                $doctorDetails = DB::table('users')->where('id', $doctor_id->user_id)->select('email', 'first_name', 'last_name')->get()->toArray();
                $lab_routes = $doctorDetails[0]->email;
                $details = [
                    'subject' => 'Action Required: Tracking Number Submitted for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'title' => 'Action Required: Tracking Number Submitted for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'tracking_id' => $tracking_id,
                    'doctor_name' => $doctorDetails[0]->first_name." ".$doctorDetails[0]->last_name,
                    'patient_name' => $treatment_plan->first_name." ".$treatment_plan->last_name,
                    'comment' => $comment,
                    'attachments' => $attachments,
                    'email' => $lab_routes,
                ];
                SubmitTrackingIdJob::dispatch($details);

                $tasks = DB::table('tasks')
                    ->where('treatment_plan_id', $treatment_plan_id)
                    ->where('type', 'staff')
                    ->where('status', '!=', 'completed')
                    ->orderByDesc('id')
                    ->get();


                foreach ($tasks as $task) {
                    DB::table('tasks')->where('id', $task->id)->update([
                        "status" => 'completed',
                        "user_id" => Auth::id(),
                    ]);
                }


                DB::table('notifications')->insert([
                    "title" => "Tracking Nr.",
                    "user_id" => $treatment_plan->user_id,
                    "type" => "doctor",
                    "body" => "View Tracking Nr. for " . $treatment_plan->p_last_name . "' Treatment Plan " . $treatment_plan->phase,
                    "treatment_plan_id" => $treatment_plan->id,
                ]);

                unset(
                    $data['_token'],
                    $data['treatment_plan_id'],
                );

                $objAudittrails = new AuditTrails();
                $saveAudittrails = $objAudittrails->addAudittrails( $treatment_plan->patientsId, $request->post('treatment_plan_id'), "Staff Submitted Tracking ID", 'S', 'D', $data);
                return response()->json(["status" => 200]);
            }
        }
        return response()->json(["status" => 400]);
    }


    public function submit_tracking_idOld(Request $request)
    {
        if (Auth::user()->role == 'staff') {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $tracking_id = ($request->post('tracking_id'));
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.user_id", "p.pricing_package", "p.first_name as p_first_name", "p.last_name as p_last_name")
                ->first();
            $tasks = DB::table('tasks')
                ->where('treatment_plan_id', $treatment_plan_id)
                ->where('type', 'staff')
                ->where('status', '!=', 'completed')
                ->orderByDesc('id')
                ->get();

            foreach ($tasks as $task) {
                DB::table('tasks')->where('id', $task->id)->update([
                    "status" => 'completed',
                    "user_id" => Auth::id(),
                ]);
            }
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    //  $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                }
            }
            $attachments = implode(',', $attachments);

            if (@$treatment_plan->case_holder == 'staff') {

                DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                    "tracking_id" => $tracking_id,
                    "shipping_date_time" => date("Y-m-d H:i:s"),
                    "case_holder" => 'doctor',
                    'previous_case_holder' => 'staff',
                    'status' => 'Shipped',
                    'expiry_date' => getExpriyDateForNewPlaFromTreatmentPlanId($treatment_plan->id, date("Y-m-d H:i:s")),
                    'is_completed' => 1,
                ]);
                $patient_id = $treatment_plan->patient_id;
                $doctor_id = DB::table('patients')->where('id', $patient_id)->first();
                $doctorDetails = DB::table('users')->where('id', $doctor_id->user_id)->select('email', 'first_name', 'last_name')->get()->toArray();
                $lab_routes = $doctorDetails[0]->email;
                $details = [
                    'subject' => 'Action Required: Tracking Number Submitted for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'title' => 'Action Required: Tracking Number Submitted for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'tracking_id' => $tracking_id,
                    'doctor_name' => $doctorDetails[0]->first_name." ".$doctorDetails[0]->last_name,
                    'patient_name' => $treatment_plan->first_name." ".$treatment_plan->last_name,
                    'comment' => $comment,
                    'attachments' => $attachments,
                    'email' => $lab_routes,
                ];
                dd($details);
                SubmitTrackingIdJob::dispatch($details);
                dd($details);
                // $task_service = (new TaskService($treatment_plan_id));
                // $task_id = $task_service->sendMail($treatment_plan_id,"doctor", "Review Tracking Nr." . $treatment_plan->phase, $treatment_plan->user_id, $comment, "staff", "doctor",$attachments); //comment from staff to lab


                $lab_routes = DB::table('users')->where('id', $treatment_plan->user_id)->pluck("email")->toArray();
                $patient_id = $treatment_plan->patient_id;
                $doctor_id = DB::table('patients')->where('id', $patient_id)->first();
                $doctorDetails = DB::table('users')->where('id', $doctor_id->user_id)->select('email', 'first_name', 'last_name')->get()->toArray();
                $lab_routes = $doctorDetails[0]->email;
                $details = [
                    'subject' => 'Action Required: Tracking Number Submitted for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'title' => 'Action Required: Tracking Number Submitted for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'tracking_id' => $tracking_id,
                    'doctor_name' => $doctorDetails[0]->first_name." ".$doctorDetails[0]->last_name,
                    'patient_name' => $treatment_plan->first_name." ".$treatment_plan->last_name,
                    'comment' => $comment,
                    'attachments' => $attachments,
                    'email' => $lab_routes,
                ];
                dd($details);
                SubmitTrackingIdJob::dispatch($details);
                // \Illuminate\Support\Facades\Notification::route('mail', $lab_routes)
                //     ->notify(new \App\Notifications\TrackingAlert($comment, "View Tracking Nr", $tracking_id, $attachments, $treatment_plan->p_first_name, $treatment_plan->p_last_name));

                $task_id = (new TaskService($treatment_plan_id));

                // if(!@$treatment_plan->tracking_id) {
                //     $task->complete_task("staff"); //complete staff task
                // }
                $tasks = DB::table('tasks')
                    ->where('treatment_plan_id', $treatment_plan_id)
                    ->where('type', 'staff')
                    ->where('status', '!=', 'completed')
                    ->orderByDesc('id')
                    ->get();

                foreach ($tasks as $task) {
                    DB::table('tasks')->where('id', $task->id)->update([
                        "status" => 'completed',
                        "user_id" => Auth::id(),
                    ]);
                }
                //    $task_id = $task->create_task("doctor", "Review Tracking Nr." . $treatment_plan->phase, $treatment_plan->user_id, $comment, "staff", "doctor",$attachments); //comment from staff to lab
                $task_id = DB::table('tasks')->where('treatment_plan_id', $treatment_plan->id)->orderBy('id', 'desc')->first();
                if ($request->hasFile('attachments') != null || $request->post('comment') != null) {
                    DB::table('comments')->insert([
                        "treatment_plan_id" => $treatment_plan_id,
                        "task_id" => $task_id->id,
                        "added_by" => Auth::user()->id,
                        "from_role" => 'staff',
                        "to_role" => 'doctor',
                        "comment" => $comment,
                        'attachments' => $attachments,
                        "created_at" => now()
                    ]);
                }
                DB::table('notifications')->insert([
                    "title" => "Tracking Nr.",
                    "user_id" => $treatment_plan->user_id,
                    "type" => "doctor",
                    "body" => "View Tracking Nr. for " . $treatment_plan->p_last_name . "' Treatment Plan " . $treatment_plan->phase,
                    "treatment_plan_id" => $treatment_plan->id,
                ]);

                return response()->json(["status" => 200]);
            } elseif ((@$treatment_plan->case_holder == 'staff' && @$treatment_plan->is_continue == 1)) {
                DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                    "tracking_id" => $tracking_id,
                    "shipping_date_time" => date("Y-m-d H:i:s"),
                    "case_holder" => 'doctor',
                    'previous_case_holder' => 'staff',
                    'is_completed' => 1,
                    'expiry_date' => getExpriyDateForNewPlaFromTreatmentPlanId($treatment_plan->id, date("Y-m-d H:i:s")),
                    'status' => 'Shipped',
                ]);
                $task_service = (new TaskService($treatment_plan_id));
                // $task_id = $task_service->create_task_withoutMail("doctor", "Review Tracking Nr." . $treatment_plan->phase, $treatment_plan->user_id, $comment, "staff", "doctor", $attachments); //comment from staff to lab
                $lab_routes = DB::table('users')->where('id', $treatment_plan->user_id)->pluck("email")->toArray();
                $patient_id = $treatment_plan->patient_id;
                $doctor_id = DB::table('patients')->where('id', $patient_id)->first();
                $doctorDetails = DB::table('users')->where('id', $doctor_id->user_id)->select('email', 'first_name', 'last_name')->get()->toArray();
                $lab_routes = $doctorDetails[0]->email;
                $details = [
                    'subject' => 'Action Required: Tracking Number Submitted for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'title' => 'Action Required: Tracking Number Submitted for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'tracking_id' => $tracking_id,
                    'doctor_name' => $doctorDetails[0]->first_name." ".$doctorDetails[0]->last_name,
                    'patient_name' => $treatment_plan->first_name." ".$treatment_plan->last_name,
                    'comment' => $comment,
                    'attachments' => $attachments,
                    'email' => $lab_routes,
                ];

                SubmitTrackingIdJob::dispatch($details);
                // \Illuminate\Support\Facades\Notification::route('mail', $lab_routes)
                //     ->notify(new \App\Notifications\TrackingAlert($comment, "View Tracking Nr", $tracking_id, $attachments, $treatment_plan->p_first_name, $treatment_plan->p_last_name));                // if(!@$treatment_plan->tracking_id) {

                $tasks = DB::table('tasks')
                    ->where('treatment_plan_id', $treatment_plan_id)
                    ->where('type', 'staff')
                    ->where('status', '!=', 'completed')
                    ->orderByDesc('id')
                    ->get();


                foreach ($tasks as $task) {
                    DB::table('tasks')->where('id', $task->id)->update([
                        "status" => 'completed',
                        "user_id" => Auth::id(),
                    ]);
                }


                DB::table('notifications')->insert([
                    "title" => "Tracking Nr.",
                    "user_id" => $treatment_plan->user_id,
                    "type" => "doctor",
                    "body" => "View Tracking Nr. for " . $treatment_plan->p_last_name . "' Treatment Plan " . $treatment_plan->phase,
                    "treatment_plan_id" => $treatment_plan->id,
                ]);
                return response()->json(["status" => 200]);
            }

        }
        return response()->json(["status" => 400]);
    }
    public function send_to_doctor_for_modification(Request $request){
        if (Auth::user()->role == 'staff') {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $tracking_id = ($request->post('tracking_id'));
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.user_id", "p.pricing_package", "p.first_name as p_first_name", "p.last_name as p_last_name")
                ->first();
            $tasks = DB::table('tasks')
                ->where('treatment_plan_id', $treatment_plan_id)
                ->where('type', 'staff')
                ->where('status', '!=', 'completed')
                ->orderByDesc('id')
                ->get();

            foreach ($tasks as $task) {
                DB::table('tasks')->where('id', $task->id)->update([
                    "status" => 'completed',
                    "user_id" => Auth::id(),
                ]);
            }

            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    //  $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                }
            }
            $attachments = implode(',', $attachments);

            if (@$treatment_plan->case_holder == 'staff') {
                DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                    "tracking_id" => $tracking_id,
                    "shipping_date_time" => date("Y-m-d H:i:s"),
                    "case_holder" => 'doctor',
                    'previous_case_holder' => 'staff',
                    'status' => 'Waiting Dr\'s Review',
                ]);

                // $task_service = (new TaskService($treatment_plan_id));
                // $task_id = $task_service->sendMail($treatment_plan_id,"doctor", "Review Tracking Nr." . $treatment_plan->phase, $treatment_plan->user_id, $comment, "staff", "doctor",$attachments); //comment from staff to lab


                $lab_routes = DB::table('users')->where('id', $treatment_plan->user_id)->pluck("email")->toArray();
                \Illuminate\Support\Facades\Notification::route('mail', $lab_routes)
                    ->notify(new \App\Notifications\TrackingAlert($comment, "View Tracking Nr", $tracking_id, $attachments,$treatment_plan->p_first_name,$treatment_plan->p_last_name));

                $task_id = (new TaskService($treatment_plan_id));

                // if(!@$treatment_plan->tracking_id) {
                //     $task->complete_task("staff"); //complete staff task
                // }
                $tasks = DB::table('tasks')
                    ->where('treatment_plan_id', $treatment_plan_id)
                    ->where('type', 'staff')
                    ->where('status', '!=', 'completed')
                    ->orderByDesc('id')
                    ->get();

                foreach ($tasks as $task) {
                    DB::table('tasks')->where('id', $task->id)->update([
                        "status" => 'completed',
                        "user_id" => Auth::id(),
                    ]);
                }
                //    $task_id = $task->create_task("doctor", "Review Tracking Nr." . $treatment_plan->phase, $treatment_plan->user_id, $comment, "staff", "doctor",$attachments); //comment from staff to lab
                $task_id = DB::table('tasks')->where('treatment_plan_id', $treatment_plan->id)->orderBy('id', 'desc')->first();
                if ($request->hasFile('attachments') != null || $request->post('comment') != null) {
                    DB::table('comments')->insert([
                        "treatment_plan_id" => $treatment_plan_id,
                        "task_id" => $task_id->id,
                        "added_by" => Auth::user()->id,
                        "from_role" => 'staff',
                        "to_role" => 'doctor',
                        "comment" => $comment,
                        'attachments' => $attachments,
                        "created_at" => now()
                    ]);
                }
                DB::table('notifications')->insert([
                    "title" => "Tracking Nr.",
                    "user_id" => $treatment_plan->user_id,
                    "type" => "doctor",
                    "body" => "View Tracking Nr. for " . $treatment_plan->p_last_name . "' Treatment Plan " . $treatment_plan->phase,
                    "treatment_plan_id" => $treatment_plan->id,
                ]);

                return response()->json(["status" => 200]);
            } elseif ((@$treatment_plan->case_holder == 'staff' && @$treatment_plan->is_continue == 1)) {
                DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                    "tracking_id" => $tracking_id,
                    "shipping_date_time" => date("Y-m-d H:i:s"),
                    "case_holder" => 'doctor',
                    'previous_case_holder' => 'staff',
                    'is_completed' => 1,
                    'expiry_date' => getExpriyDateForNewPlaFromTreatmentPlanId($treatment_plan->id, date("Y-m-d H:i:s")),
                    'status' => 'Shipped',
                ]);
                $task_service = (new TaskService($treatment_plan_id));
                // $task_id = $task_service->create_task_withoutMail("doctor", "Review Tracking Nr." . $treatment_plan->phase, $treatment_plan->user_id, $comment, "staff", "doctor", $attachments); //comment from staff to lab
                $lab_routes = DB::table('users')->where('id', $treatment_plan->user_id)->pluck("email")->toArray();
                \Illuminate\Support\Facades\Notification::route('mail', $lab_routes)
                    ->notify(new \App\Notifications\TrackingAlert($comment, "View Tracking Nr", $tracking_id, $attachments,$treatment_plan->p_first_name,$treatment_plan->p_last_name));                // if(!@$treatment_plan->tracking_id) {

                $tasks = DB::table('tasks')
                    ->where('treatment_plan_id', $treatment_plan_id)
                    ->where('type', 'staff')
                    ->where('status', '!=', 'completed')
                    ->orderByDesc('id')
                    ->get();


                foreach ($tasks as $task) {
                    DB::table('tasks')->where('id', $task->id)->update([
                        "status" => 'completed',
                        "user_id" => Auth::id(),
                    ]);
                }


                DB::table('notifications')->insert([
                    "title" => "Tracking Nr.",
                    "user_id" => $treatment_plan->user_id,
                    "type" => "doctor",
                    "body" => "View Tracking Nr. for " . $treatment_plan->p_last_name . "' Treatment Plan " . $treatment_plan->phase,
                    "treatment_plan_id" => $treatment_plan->id,
                ]);
                return response()->json(["status" => 200]);
            }
        }
        return response()->json(["status" => 400]);
    }
    public function request_setup_files(Request $request)
    {
        if (Auth::user()->role == 'staff') {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.user_id", "p.pricing_package")
                ->first();
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    // $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                }
            }
            $attachments = implode(',', $attachments);
            if (@$treatment_plan->case_holder == 'staff' && @$treatment_plan->is_completed == 1) {
                $task = (new TaskService($treatment_plan_id));
                $task->complete_task("staff"); //complete staff task
                if ($treatment_plan->is_completed == 1) {
                    $title = 'Download Setup Files';
                } else {
                    $title = 'Review Setup';
                }
                if ($treatment_plan->is_continue == 1) {
                    $title = 'Production';
                } else {
                    $title = 'Review Setup';
                }
                //add lab task
                $task_id = $task->create_task("lab", $title, $treatment_plan->lab, $comment, "staff", "lab", $attachments); //comment from staff to lab


                if ($task_id != false) {
                    DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                        "case_holder" => "lab",
                        "previous_case_holder" => "staff"
                    ]);
                }
                return response()->json(["status" => 200]);
            }
        }
        return response()->json(["status" => 400]);
    }
    public function send_to_the_doctor_for_modification(Request $request)
    {        
        if (Auth::user()->role == 'staff') {
            $data = $request->all();
            unset(
                $data['attachments'],
            );
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.user_id", "p.pricing_package", "p.setup_type", "p.is_setup_type_approved", "p.id as patientsId")
                ->first();

            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    // $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                    $data['attachments'][] = $filename;
                }
            }
            $attachments = implode(',', $attachments);
            $patient_id = $treatment_plan->patient_id;
            $doctor_id = DB::table('patients')->where('id', $patient_id)->first();
            $doctorDetails = DB::table('users')->where('id', $doctor_id->user_id)->select('email', 'first_name', 'last_name')->get()->toArray();
            $lab_routes = $doctorDetails[0]->email;

            if($request->post('action') == 'send-from-staff-to-doctor'){
                $details = [
                    'subject' => 'Action Required: Additional Information Needed for Your Case of ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'doctor_name' => $doctorDetails[0]->first_name." ".$doctorDetails[0]->last_name,
                    'patient_name' => $treatment_plan->first_name." ".$treatment_plan->last_name,
                    'comment' => $comment,
                    'attachments' => $attachments,
                    'email' => $lab_routes,
                ];
                SentToDoctorForModificatinJob::dispatch($details);
            }


            // \Illuminate\Support\Facades\Notification::route('mail', $lab_routes)
            //     ->notify(new \App\Notifications\ModifyAlert($comment, $attachments, $treatment_plan->first_name, $treatment_plan->last_name));
            // dd('here');
            if (@$treatment_plan->case_holder == 'staff') {
                if ($treatment_plan->is_treatment_submitted == 1) {
                    $aligner_steps = intval($request->post('steps'));
                    if ($aligner_steps > 0) {
                        $currentDate = date('Y-m-d');  // Get the current date
                        $cancellationDate = date('Y-m-d', strtotime($currentDate . ' +31 days'));  // Add 31 days | Will be cancelled on this date

                        if($request->post('action') && $request->post('action') == 'send-for-approval'){
                            $details = [
                                'subject' => 'Action Required: ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' has requested approval for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                                'title' => 'Action Required: ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' has requested approval for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                                'doctor_name' => $doctorDetails[0]->first_name." ".$doctorDetails[0]->last_name,
                                'patient_name' => $treatment_plan->first_name." ".$treatment_plan->last_name,
                                'comment' => $comment,
                                'attachments' => $attachments,
                                'aligner_steps' => $aligner_steps,
                                'email' => $lab_routes,
                                'iframe_link' => $treatment_plan->iframe_link,
                                'patient_link' => $treatment_plan->patient_link,
                                'staff_name' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                            ];

                            SendToDoctorFromStaffForApprovalJob::dispatch($details);
                        }
                        DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                            "aligner_steps" => $aligner_steps,
                            "is_lab_cancel" => 0,
                            "cancellation_date" => $cancellationDate,
                        ]);
                    }
                }

                $tasks = DB::table('tasks')
                    ->where('treatment_plan_id', $treatment_plan_id)
                    ->where('type', 'staff')
                    ->where('status', '!=', 'completed')
                    ->orderByDesc('id')
                    ->get();

                foreach ($tasks as $task) {
                    DB::table('tasks')->where('id', $task->id)->update([
                        "status" => 'completed',
                        "user_id" => Auth::id(),
                    ]);
                }

                $task_id = DB::table('tasks')->where('treatment_plan_id', $treatment_plan_id)->orderBy('id', 'desc')->first();
                if ($treatment_plan->case_holder == 'staff' && $treatment_plan->previous_case_holder == 'staff') {
                    $title = 'Review and Approve Treatment Plan ' . $treatment_plan->phase;
                } elseif ($treatment_plan->case_holder == 'staff' && $treatment_plan->previous_case_holder == 'advisor') {
                    $title = 'Review and Approve Advisor Comment ' . $treatment_plan->phase;
                } elseif (($request->post('action') == 'send-from-staff-to-doctor') && $request->post('requestNewScanCheckbox') == 'no') {
                    $title = 'Modification requested';
                } elseif (($request->post('action') == 'send-from-staff-to-doctor') && $request->post('requestNewScanCheckbox') == 'yes') {
                    $title = 'New Scan Files requested';
                } else {
                    $title = 'Review Setup ' . $treatment_plan->phase;
                }


                $latest = DB::table('tasks')->insert([
                    "treatment_plan_id" => $treatment_plan_id,
                    "task" => $title,
                    "type" => 'doctor',
                    "user_id" => $treatment_plan->user_id,
                    "status" => "pending",
                    "created_at" => now()
                ]);
                if ($request->hasFile('attachments') != null || $request->post('comment') != null) {
                    DB::table('comments')->insert([
                        "treatment_plan_id" => $treatment_plan_id,
                        "task_id" => $task_id->id,
                        "added_by" => Auth::user()->id,
                        "from_role" => 'staff',
                        "to_role" => 'doctor',
                        "comment" => $comment,
                        'attachments' => $attachments,
                        // "created_at" => date("Y-m-d H:i:s"),

                        "created_at" => now()
                    ]);
                }
                if($request->post('action') && $request->post('action') == 'send-for-approval'){
                    $send_for_approval = true;
                    $status = 'Waiting Doctor’s Review';
                } elseif ($request->post('action') && ($request->post('action') == 'send-from-staff-to-doctor') && $request->post('requestNewScanCheckbox') == 'no') {
                    $send_for_approval = false;
                    $status = 'Waiting Doctor’s Modification';
                } elseif ($request->post('action') && ($request->post('action') == 'send-from-staff-to-doctor') && $request->post('requestNewScanCheckbox') == 'yes') {
                    $send_for_approval = false;
                    $status = 'New Scan Files requested';
                } else {
                    $send_for_approval = false;
                    $status = 'Waiting Doctor’s Modification';
                }

                if($treatment_plan->setup_type == 1 && $treatment_plan->is_setup_type_approved == 1 && $treatment_plan->is_link_updated == 0){
                    DB::table('patients')->where('id', $treatment_plan->patientsId)->update([
                        'setup_type' => 2,
                        'is_setup_type_approved' => 0,
                    ]);
                }
                DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
                    'is_completed' => "0",
                    'is_lab_cancel' => 0,
                    'send_for_approval' => $send_for_approval,
                    'request_new_scan' => $request->post('requestNewScanCheckbox') == 'yes' ? 1 : 0,
                    'dr_request_modification' => false,
                    "case_holder" => "doctor",
                    "previous_case_holder" => "staff",
                    "status" => $status,
                ]);

                unset(
                    $data['_token'],
                    $data['action'],
                    $data['treatment_plan_id'],
                );

                $objAudittrails = new AuditTrails();
                
                if($request->post('action') && $request->post('action') == 'send-for-approval'){
                    $saveAudittrails = $objAudittrails->addAudittrails( $treatment_plan->patientsId, $request->post('treatment_plan_id'), "Staff Sent the Case to the Doctor for Approval", 'S', 'D', $data);
                } elseif ($request->post('action') && ($request->post('action') == 'send-from-staff-to-doctor') && $request->post('requestNewScanCheckbox') == 'no') {
                    $saveAudittrails = $objAudittrails->addAudittrails( $treatment_plan->patientsId, $request->post('treatment_plan_id'), "Staff Sent the Case to the Doctor for Modification", 'S', 'D', $data);
                } elseif ($request->post('action') && ($request->post('action') == 'send-from-staff-to-doctor') && $request->post('requestNewScanCheckbox') == 'yes') {
                    $saveAudittrails = $objAudittrails->addAudittrails( $treatment_plan->patientsId, $request->post('treatment_plan_id'), "Staff Requested New Scan Files", 'S', 'D', $data);
                }

                return response()->json(["status" => 200]);
            }
        }
        return response()->json(["status" => 400]);
    }
    
    public function send_form_staff_to_doctor(Request $request)
    {
        if (Auth::user()->role == 'staff') {
            $data = $request->all();

            unset(
                $data['attachments'],
            );
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.user_id", "p.pricing_package", "p.setup_type", "p.is_setup_type_approved", "p.id as patientsId")
                ->first();

            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    // $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                    $data['attachments'][] = $filename;
                }
            }
            $attachments = implode(',', $attachments);
            $patient_id = $treatment_plan->patient_id;
            $doctor_id = DB::table('patients')->where('id', $patient_id)->first();
            $doctorDetails = DB::table('users')->where('id', $doctor_id->user_id)->select('email', 'first_name', 'last_name')->get()->toArray();
            $lab_routes = $doctorDetails[0]->email;

            if($request->post('action') == 'send-from-staff-to-doctor'){
                $details = [
                    'subject' => 'Action Required: Additional Information Needed for Your Case of ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'doctor_name' => $doctorDetails[0]->first_name." ".$doctorDetails[0]->last_name,
                    'patient_name' => $treatment_plan->first_name." ".$treatment_plan->last_name,
                    'comment' => $comment,
                    'attachments' => $attachments,
                    'email' => $lab_routes,
                ];
                SentToDoctorForModificatinJob::dispatch($details);
            }


            // \Illuminate\Support\Facades\Notification::route('mail', $lab_routes)
            //     ->notify(new \App\Notifications\ModifyAlert($comment, $attachments, $treatment_plan->first_name, $treatment_plan->last_name));
            // dd('here');
            if (@$treatment_plan->case_holder == 'staff') {
                if ($treatment_plan->is_treatment_submitted == 1) {
                    $aligner_steps = intval($request->post('steps'));
                    if ($aligner_steps > 0) {
                        $currentDate = date('Y-m-d');  // Get the current date
                        $cancellationDate = date('Y-m-d', strtotime($currentDate . ' +31 days'));  // Add 31 days | Will be cancelled on this date

                        if($request->post('action') && $request->post('action') == 'send-for-approval'){
                            $details = [
                                'subject' => 'Action Required: ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' has requested approval for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                                'title' => 'Action Required: ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' has requested approval for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                                'doctor_name' => $doctorDetails[0]->first_name." ".$doctorDetails[0]->last_name,
                                'patient_name' => $treatment_plan->first_name." ".$treatment_plan->last_name,
                                'comment' => $comment,
                                'attachments' => $attachments,
                                'aligner_steps' => $aligner_steps,
                                'email' => $lab_routes,
                                'iframe_link' => $treatment_plan->iframe_link,
                                'patient_link' => $treatment_plan->patient_link,
                                'staff_name' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                            ];

                            SendToDoctorFromStaffForApprovalJob::dispatch($details);
                        }
                        DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                            "aligner_steps" => $aligner_steps,
                            "is_lab_cancel" => 0,
                            "cancellation_date" => $cancellationDate,
                        ]);
                    }
                }

                $tasks = DB::table('tasks')
                    ->where('treatment_plan_id', $treatment_plan_id)
                    ->where('type', 'staff')
                    ->where('status', '!=', 'completed')
                    ->orderByDesc('id')
                    ->get();

                foreach ($tasks as $task) {
                    DB::table('tasks')->where('id', $task->id)->update([
                        "status" => 'completed',
                        "user_id" => Auth::id(),
                    ]);
                }

                $task_id = DB::table('tasks')->where('treatment_plan_id', $treatment_plan_id)->orderBy('id', 'desc')->first();
                if ($treatment_plan->case_holder == 'staff' && $treatment_plan->previous_case_holder == 'staff') {
                    $title = 'Review and Approve Treatment Plan ' . $treatment_plan->phase;
                } elseif ($treatment_plan->case_holder == 'staff' && $treatment_plan->previous_case_holder == 'advisor') {
                    $title = 'Review and Approve Advisor Comment ' . $treatment_plan->phase;
                } elseif ($request->post('action') == 'send-from-staff-to-doctor') {
                    $title = 'Modification requested';
                } else {
                    $title = 'Review Setup ' . $treatment_plan->phase;
                }


                $latest = DB::table('tasks')->insert([
                    "treatment_plan_id" => $treatment_plan_id,
                    "task" => $title,
                    "type" => 'doctor',
                    "user_id" => $treatment_plan->user_id,
                    "status" => "pending",
                    "created_at" => now()
                ]);
                if ($request->hasFile('attachments') != null || $request->post('comment') != null) {
                    DB::table('comments')->insert([
                        "treatment_plan_id" => $treatment_plan_id,
                        "task_id" => $task_id->id,
                        "added_by" => Auth::user()->id,
                        "from_role" => 'staff',
                        "to_role" => 'doctor',
                        "comment" => $comment,
                        'attachments' => $attachments,
                        // "created_at" => date("Y-m-d H:i:s"),

                        "created_at" => now()
                    ]);
                }
                if($request->post('action') && $request->post('action') == 'send-for-approval'){
                    $send_for_approval = true;
                    $status = 'Waiting Doctor’s Review';
                } else {
                    $send_for_approval = false;
                    $status = 'Waiting Doctor’s Modification';
                }

                if($treatment_plan->setup_type == 1 && $treatment_plan->is_setup_type_approved == 1 && $treatment_plan->is_link_updated == 0){
                    DB::table('patients')->where('id', $treatment_plan->patientsId)->update([
                        'setup_type' => 2,
                        'is_setup_type_approved' => 0,
                    ]);
                }
                DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
                    'is_completed' => "0",
                    'is_lab_cancel' => 0,
                    'send_for_approval' => $send_for_approval,
                    'dr_request_modification' => false,
                    "case_holder" => "doctor",
                    "previous_case_holder" => "staff",
                    "status" => $status,
                ]);

                unset(
                    $data['_token'],
                    $data['action'],
                    $data['treatment_plan_id'],
                );

                $objAudittrails = new AuditTrails();
                $saveAudittrails = $objAudittrails->addAudittrails( $treatment_plan->patientsId, $request->post('treatment_plan_id'), "Staff Sent the Case to the Doctor for Approval", 'S', 'D', $data);
                return response()->json(["status" => 200]);
            }
        }
        return response()->json(["status" => 400]);
    }

    public function send_from_doctor_to_staff(Request $request)
    {
        if (Auth::user()->role == 'doctor') {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.user_id", "p.pricing_package")
                ->first();

            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    // $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                }
            }
            $attachments = implode(',', $attachments);
            if (@$treatment_plan->case_holder == 'doctor') {
                $task = (new TaskService($treatment_plan_id));
                $task->complete_task("doctor", $treatment_plan->user_id); //complete doctor task
                //$task_id = $task->create_task("staff", "Case Review", null, $comment, "doctor", "staff",$attachments);
                $tasks = DB::table('tasks')
                    ->where('treatment_plan_id', $treatment_plan_id)
                    ->where('type', 'doctor')
                    ->where('status', '!=', 'completed')
                    ->orderByDesc('id')
                    ->get();

                foreach ($tasks as $task) {
                    DB::table('tasks')->where('id', $task->id)->update([
                        "status" => 'completed',
                        "user_id" => Auth::id(),
                    ]);
                }
                $latest = DB::table('tasks')->insert([
                    "treatment_plan_id" => $treatment_plan_id,
                    "task" => 'Case Review',
                    "type" => 'staff',
                    "user_id" => null,
                    "status" => "pending",
                    "created_at" => now()
                ]);
                $task_id = DB::table('tasks')->where('treatment_plan_id', $treatment_plan_id)->orderBy('id', 'desc')->first();
                if ($request->hasFile('attachments') != null || $request->post('comment') != null) {
                    DB::table('comments')->insert([
                        "treatment_plan_id" => $treatment_plan_id,
                        "task_id" => $task_id->id,
                        "added_by" => Auth::user()->id,
                        "from_role" => 'doctor',
                        "to_role" => 'staff',
                        "comment" => $comment,
                        'attachments' => $attachments,
                        // "created_at" => date("Y-m-d H:i:s"),

                        "created_at" => now()
                    ]);
                }

                $details = [
                    'subject' => 'Action Required: Additional Information Needed for Your Case of ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'title' => 'Action Required: Additional Information Needed for Your Case of ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'comment' => $comment,
                    'attachments' => $attachments,
                    'patient_name' => $treatment_plan->first_name." ".$treatment_plan->last_name,
                ];

                $staff = DB::table('users')
                        ->where('role', 'staff')
                        ->get(['first_name', 'last_name', 'email'])
                        ->toArray();

                SendToStaffFromDoctorModificationJob::dispatch($staff, $details);
                // \Illuminate\Support\Facades\Notification::route('mail', $lab_routes)
                //     ->notify(new \App\Notifications\CustomAlert("Thank you for placing order, our staff will review the case requirement and will reply you if there is any additional requirement. Added Comment: $comment ", "Thank you for placing order", $attachments, $treatment_plan->first_name, $treatment_plan->last_name));

                if ($task_id != false) {
                    DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                        "case_holder" => "staff",
                        "previous_case_holder" => "doctor",
                        "status" => "Waiting Staff Review",
                        "is_editable" => 0,
                    ]);
                }
            }
        }
    }

    public function doctor_send_to_staff_request_modification(Request $request)
    {
        if (Auth::user()->role == 'doctor') {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.user_id", "p.pricing_package")
                ->first();

            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    // $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                }
            }
            $attachments = implode(',', $attachments);
            if (@$treatment_plan->case_holder == 'doctor') {

                $details = [
                    'subject' => 'Action Required: Doctor has requested a modification for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'title' => 'Action Required: Doctor has requested a modification for Patient : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'patient_name' => $treatment_plan->first_name." " . $treatment_plan->last_name,
                    'comment' => $comment,
                    'attachments' => $attachments,
                ];

                $staff = DB::table('users')
                        ->where('role', 'staff')
                        ->get(['first_name', 'last_name', 'email'])
                        ->toArray();

                DoctorSendToStaffForModificationJob::dispatch($staff, $details);

                $task = (new TaskService($treatment_plan_id));
                $task->complete_task("doctor", $treatment_plan->user_id); //complete doctor task
                //$task_id = $task->create_task("staff", "Case Review", null, $comment, "doctor", "staff",$attachments);
                $tasks = DB::table('tasks')
                    ->where('treatment_plan_id', $treatment_plan_id)
                    ->where('type', 'doctor')
                    ->where('status', '!=', 'completed')
                    ->orderByDesc('id')
                    ->get();

                foreach ($tasks as $task) {
                    DB::table('tasks')->where('id', $task->id)->update([
                        "status" => 'Modification Setup ' . $treatment_plan->phase,
                        "user_id" => Auth::id(),
                    ]);
                }
                $latest = DB::table('tasks')->insert([
                    "treatment_plan_id" => $treatment_plan_id,
                    "task" => 'Modification Setup ' . $treatment_plan->phase,
                    "type" => 'staff',
                    "user_id" => null,
                    "status" => "pending",
                    "created_at" => now()
                ]);
                $task_id = DB::table('tasks')->where('treatment_plan_id', $treatment_plan_id)->orderBy('id', 'desc')->first();
                if ($request->hasFile('attachments') != null || $request->post('comment') != null) {
                    DB::table('comments')->insert([
                        "treatment_plan_id" => $treatment_plan_id,
                        "task_id" => $task_id->id,
                        "added_by" => Auth::user()->id,
                        "from_role" => 'doctor',
                        "to_role" => 'staff',
                        "comment" => $comment,
                        'attachments' => $attachments,
                        // "created_at" => date("Y-m-d H:i:s"),

                        "created_at" => now()
                    ]);
                }

                // $routes = DB::table('users')->where('id', Auth::id())->pluck("email")->toArray();

                // \Illuminate\Support\Facades\Notification::route('mail', $routes)
                //     ->notify(new \App\Notifications\CustomAlert("Thank you for placing order, our staff will review the case requirement and will reply you if there is any additional requirement. Added Comment: $comment ", "Thank you for placing order", $attachments, $treatment_plan->first_name, $treatment_plan->last_name));


                // $lab_routes = DB::table('users')->where('role', "staff")->pluck("email")->toArray();

                // \Illuminate\Support\Facades\Notification::route('mail', $lab_routes)
                //     ->notify(new \App\Notifications\CustomAlert("Thank you for placing order, our staff will review the case requirement and will reply you if there is any additional requirement. Added Comment: $comment ", "Thank you for placing order", $attachments, $treatment_plan->first_name, $treatment_plan->last_name));

                if ($task_id != false) {
                    DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                        "case_holder" => "staff",
                        "send_for_approval" => false,
                        "is_approved" => 0,
                        "dr_request_modification" => true,
                        "previous_case_holder" => "doctor",
                        "status" => "Doctor requests a Modification to Setup ". $treatment_plan->phase,
                        "is_editable" => 0,
                    ]);
                }
            }
        }
    }

    public function approve_quick_setup(Request $request)
    {
        if (Auth::user()->role == 'doctor') {
            $data = $request->all();

            unset(
                $data['attachments'],
            );
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.user_id", "p.pricing_package", "p.id as patientsId")
                ->first();

            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    // $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                    $data['attachments'][] = $filename;
                }
            }
            $attachments = implode(',', $attachments);
            if (@$treatment_plan->case_holder == 'doctor') {

                $details = [
                    'subject' => 'Action Required: The Doctor Has Approved the Quick Setup : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'title' => 'Action Required: The Doctor Has Approved the Quick Setup : ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'patient_name' => $treatment_plan->first_name." " . $treatment_plan->last_name,
                    'comment' => $comment,
                    'attachments' => $attachments,
                ];

                $staff = DB::table('users')
                        ->where('role', 'staff')
                        ->get(['first_name', 'last_name', 'email'])
                        ->toArray();

                DoctorSendToStaffForModificationJob::dispatch($staff, $details);

                $task = (new TaskService($treatment_plan_id));
                $task->complete_task("doctor", $treatment_plan->user_id); //complete doctor task
                //$task_id = $task->create_task("staff", "Case Review", null, $comment, "doctor", "staff",$attachments);
                $tasks = DB::table('tasks')
                    ->where('treatment_plan_id', $treatment_plan_id)
                    ->where('type', 'doctor')
                    ->where('status', '!=', 'completed')
                    ->orderByDesc('id')
                    ->get();

                foreach ($tasks as $task) {
                    DB::table('tasks')->where('id', $task->id)->update([
                        "status" => 'Quick Setup Approved',
                        "user_id" => Auth::id(),
                    ]);
                }

                $latest = DB::table('tasks')->insert([
                    "treatment_plan_id" => $treatment_plan_id,
                    "task" => 'Quick Setup Approved',
                    "type" => 'staff',
                    "user_id" => null,
                    "status" => "pending",
                    "created_at" => now()
                ]);
                $task_id = DB::table('tasks')->where('treatment_plan_id', $treatment_plan_id)->orderBy('id', 'desc')->first();
                if ($request->hasFile('attachments') != null || $request->post('comment') != null) {
                    DB::table('comments')->insert([
                        "treatment_plan_id" => $treatment_plan_id,
                        "task_id" => $task_id->id,
                        "added_by" => Auth::user()->id,
                        "from_role" => 'doctor',
                        "to_role" => 'staff',
                        "comment" => $comment,
                        'attachments' => $attachments,
                        // "created_at" => date("Y-m-d H:i:s"),

                        "created_at" => now()
                    ]);
                }

                if ($task_id != false) {
                    DB::table('patients')->where('id', $treatment_plan->patientsId)->update([
                        "setup_type" => 1,
                        "is_setup_type_approved" => 1
                    ]);
                    DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                        "case_holder" => "staff",
                        "send_for_approval" => false,
                        "dr_request_modification" => true,
                        "previous_case_holder" => "doctor",
                        "status" => "Quick Setup Approved",
                        "is_editable" => 0,
                    ]);
                }

                unset(
                    $data['_token'],
                    $data['action'],
                    $data['treatment_plan_id'],
                );

                $objAudittrails = new AuditTrails();
                $saveAudittrails = $objAudittrails->addAudittrails( $treatment_plan->patientsId, $request->post('treatment_plan_id'), "Doctor Approved Quick Setup", 'D', 'S', $data);

            }
        }
    }

    public function cancel_treatment_request(Request $request)
    {
        if (Auth::user()->role == 'lab') {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.user_id", "p.first_name", "p.last_name")
                ->first();
            if (@$treatment_plan->case_holder == 'lab') {
                $details = [
                        'subject' => 'Action Required: Required cancellation request submitted for Patient: ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                        'title' => 'Action Required: Required cancellation request submitted for Patient: ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                        'patient_name' => $treatment_plan->first_name." ".$treatment_plan->last_name,
                        'comment' => $comment,
                        'lab_name' =>  Auth::user()->first_name. ' ' . Auth::user()->last_name,
                    ];
                $staff = DB::table('users')
                                ->where('role', 'staff')
                                ->get(['first_name', 'last_name', 'email'])
                                ->toArray();

                CancelTreatmentByLabJob::dispatch($staff, $details);

                $task = (new TaskService($treatment_plan_id));
                $task->complete_task("lab");
                //add staff task + comment
                $task_id = $task->create_task("staff", "Lab Cancelled", null, $comment, "lab", "staff"); //comment from lab to staff
                $task->liveAlert("Treatment request cancelled by Al Secret lab.", null, "staff", $task_id); //cancellation alert
                //cancel lab request
                DB::table('lab_requests')->where('treatment_plan_id', $treatment_plan->id)->where('user_id', Auth::user()->id)->update([
                    "is_canceled" => 1,
                ]);
                //update treatment plan
                DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                    "is_treatment_submitted" => 0,
                    "is_lab_cancel" => 0,
                    "is_sent_to_lab" => 0,
                    "case_holder" => "staff",
                    "previous_case_holder" => "lab",
                    "status" => "Waiting Staff Review",
                    "lab" => null,
                ]);
            }
        }
    }

    public function cancel_treatment_after_submit(Request $request)
    {
        if (Auth::user()->role == 'lab') {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.user_id", "p.first_name", "p.last_name")
                ->first();
            if (@$treatment_plan->case_holder == 'lab') {
                $details = [
                        'subject' => 'Action Required: Required cancellation request submitted for Patient: ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                        'title' => 'Action Required: Required cancellation request submitted for Patient: ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                        'patient_name' => $treatment_plan->first_name." ".$treatment_plan->last_name,
                        'comment' => $comment,
                        'lab_name' =>  Auth::user()->first_name. ' ' . Auth::user()->last_name,
                    ];
                $staff = DB::table('users')
                                ->where('role', 'staff')
                                ->get(['first_name', 'last_name', 'email'])
                                ->toArray();

                CancelTreatmentByLabJob::dispatch($staff, $details);

                $task = (new TaskService($treatment_plan_id));
                $task->complete_task("lab");
                //add staff task + comment
                $task_id = $task->create_task("staff", "Lab Cancelled", null, $comment, "lab", "staff"); //comment from lab to staff
                $task->liveAlert("Treatment request cancelled by Al Secret lab.", null, "staff", $task_id); //cancellation alert
                //cancel lab request
                DB::table('lab_requests')->where('treatment_plan_id', $treatment_plan->id)->where('user_id', Auth::user()->id)->update([
                    "is_canceled" => 1,
                ]);
                //update treatment plan
                DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                    "is_treatment_submitted" => 0,
                    "is_lab_cancel" => 1,
                    "is_sent_to_lab" => 0,
                    "case_holder" => "staff",
                    "previous_case_holder" => "lab",
                    "status" => "Waiting Staff Review",
                    "lab" => null,
                ]);
            }
        }
    }

    public function reject_treatment(Request $request)
    {
        if (Auth::user()->role == 'staff') {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->Join("users as u", function ($join) {
                    $join->on("p.user_id", "=", "u.id");
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.user_id", "u.email as doctor_email", "p.pricing_package")
                ->first();

            if (@$treatment_plan->case_holder == 'staff' ) {
                $task = (new TaskService($treatment_plan_id));
                $task->complete_task("staff");
                $task->liveAlert("Treatment plan rejected by Al Secret staff.", $treatment_plan->user_id, "doctor");
                if ($comment != '' && $comment != null) {
                    DB::table('comments')->insert([
                        "treatment_plan_id" => $treatment_plan->id,
                        "added_by" => Auth::user()->id,
                        "from_role" => "staff",
                        "to_role" => "doctor",
                        "comment" => $comment,
                        "created_at" => now()
                    ]);
                }
                DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                    "is_rejected" => 1,
                    "case_holder" => "doctor",
                    "dr_request_modification" => false,
                    "previous_case_holder" => "staff",
                    "status" => "Cancelled",
                ]);

                $order_id = @DB::table('orders')->where('treatment_plan_id', $treatment_plan_id)->where('is_deleted', 0)->first()->id;
                if (@$order_id) {
                    DB::table('orders')->where('id', $order_id)->update([
                        "status" => "cancelled",
                    ]);
                }

                $patient_id = $treatment_plan->patient_id;
                $doctor_id = DB::table('patients')->where('id', $patient_id)->first();
                $doctorDetails = DB::table('users')->where('id', $doctor_id->user_id)->select('email', 'first_name', 'last_name')->get()->toArray();
                $doctor_email = $doctorDetails[0]->email;
                $details = [
                    'subject' => 'Action Required: ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' has rejected the treatment plan for Patient ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'title' => 'Action Required: ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' has rejected the treatment plan for Patient ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                    'patient_name' => $treatment_plan->first_name." " . $treatment_plan->last_name,
                    'doctor_name' => $doctorDetails[0]->first_name." ".$doctorDetails[0]->last_name,
                    'comment' => $comment,
                    'email' => $doctor_email,
                    'staff_name' => Auth::user()->first_name . ' ' . Auth::user()->last_name
                ];

                RejectTreatmentByStaffJob::dispatch($details);
            }
        }
    }

    public function allow_edit(Request $request)
    {
        if (Auth::user()->role == 'staff' || Auth::user()->role == 'superadmin') {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->Join("users as u", function ($join) {
                    $join->on("p.user_id", "=", "u.id");
                })
                ->select("tp.*", "p.user_id", "u.email as doctor_email", "p.pricing_package")
                ->first();
            if (@$treatment_plan) {
                if (@$treatment_plan->is_editable == 0 && $treatment_plan->case_holder != "doctor") {
                    DB::table('tasks')->insert([
                        "treatment_plan_id" => $treatment_plan_id,
                        "task" => 'Edit Allowed',
                        "type" => 'doctor',
                        "user_id" => $treatment_plan->user_id,
                        "status" => "pending",
                        "created_at" => now()
                    ]);
                } else {
                    DB::table('tasks')
                        ->where('treatment_plan_id', $treatment_plan->id)
                        ->where('task', 'Edit Allowed')
                        ->update([
                            'status' => "completed",
                        ]);
                }
                DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                    "is_editable" => $treatment_plan->is_editable == 1 ? 0 : 1,
                ]);
            }
        }
        return response()->json();
    }

    // Done By Parth
    public function reopenCase(Request $request)
    {
        $treatment_plan_id = $request->post('treatment_plan_id');
        $comment = $request->post('comment');
        $treatment_plan = DB::table('p_treatment_plans as tp')
            ->where('tp.id', $treatment_plan_id)
            // ->where('tp.status', 'Production')
            //   ->where('is_completed', 0)
            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", "=", "p.id")
                    ->where("p.is_deleted", 0);
            })
            ->Join("users as u", function ($join) {
                $join->on("p.user_id", "=", "u.id");
            })
            ->select("tp.*", "p.user_id", "p.first_name", "p.last_name", "u.email as doctor_email", "p.pricing_package", "p.confidence_package_duration")
            ->first();
        if ($treatment_plan) {
            // $task = new TaskService($treatment_plan_id);
            // $task->complete_task("staff");
            // $task_id = $task->create_task("doctor", "Review and Approve Treatment Plan" , null, null, "staff", "doctor");
            // $task_id = $task->create_task("staff", "Case Review", null, $comment, "lab", "staff"); //comment from staff to doctor
            $latest = DB::table('tasks')->insert([
                "treatment_plan_id" => $treatment_plan_id,
                "task" => 'Case Reopened',
                "type" => 'staff',
                "user_id" => null,
                "status" => "pending",
                "created_at" => now()
            ]);
            $task_id = DB::table('tasks')->where('treatment_plan_id', $treatment_plan_id)->orderBy('id', 'desc')->first();
            if ($comment) {
                DB::table('comments')->insert([
                    "treatment_plan_id" => $treatment_plan_id,
                    "task_id" => $task_id->id,
                    "added_by" => Auth::user()->id,
                    "from_role" => 'admin',
                    "to_role" => 'staff',
                    "comment" => $comment,

                    "created_at" => now()
                ]);
            }

            $tasks = DB::table('tasks')
                ->where('treatment_plan_id', $treatment_plan_id)
                ->where('type', '==', 'staff')
                ->where('status', '!=', 'completed')
                ->orderByDesc('id')
                ->get();

            foreach ($tasks as $task) {
                DB::table('tasks')->where('id', $task->id)->update([
                    "status" => 'completed',
                    "user_id" => Auth::id(),
                ]);
            }
            if ($treatment_plan_id != null) {
                DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
                    "case_holder" => "staff",
                    "previous_case_holder" => "Admin",
                    "status" => "Waiting Staff Review",
                    "is_completed" => 0,
                    "is_cancelled" => 0,
                    "is_submitted" => 1,
                    "is_continue" => 0,
                    // "tracking_id" => null,
                    // "setup_files_link" => null,
                    // "treatment_link" => null,
                    // "iframe_link" => null,
                    // "patient_link" => null,
                    "is_treatment_submitted" => 0,
                    "is_lab_cancel" => 0,
                    "is_sent_to_lab" => 0,
                    "is_rejected" => 0,
                    "completed_at" => null,
                    "setup_approval_date" => null,
                    // "treatment_plan_duration" => null,

                ]);
                $routes = DB::table('users')->where('role', 'staff')->pluck("email")->toArray();
                \Illuminate\Support\Facades\Notification::route('mail', $routes)
                    ->notify(new \App\Notifications\CustomAlert("Case reopened for user " . $treatment_plan->first_name . " " . $treatment_plan->last_name, "Case has been reopened", [], $treatment_plan->first_name, $treatment_plan->last_name));
            }
            // if ($task_id != null) {

            //     $order_id = @DB::table('orders')->where('treatment_plan_id', $treatment_plan_id)->where('is_deleted', 0)->first()->id;
            //     if (@$order_id) {
            //         DB::table('orders')->where('id', $order_id)->update([
            //             "deposit" =>  null,
            //             "datetime" => null,
            //             "status" => 'reopen',
            //         ]);
            //     }
            // }
        }
        return response()->json();
    }

        // Done By Parth
        // use Carbon\Carbon;

        public function setReminderForDoctor(Request $request)
        {
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $request->treatment_plan_id)
                ->join('patients as p', function ($join) {
                    $join->on('tp.patient_id', '=', 'p.id')
                        ->where('p.is_deleted', 0);
                })
                ->join('users as u', function ($join) {
                    $join->on('p.user_id', '=', 'u.id');
                })
                ->select('tp.*', 'p.user_id', 'p.first_name', 'p.last_name', 'u.email as doctor_email')
                ->first();

            if (!$treatment_plan) {
                return response()->json(['success' => false, 'message' => 'Treatment plan not found'], 404);
            }

            // Parse Berlin time
            $reminderDateTime = Carbon::parse($request->reminderDatetime, 'Europe/Berlin');

            // Check if datetime is in the future
            $nowBerlin = Carbon::now('Europe/Berlin');
            if ($reminderDateTime->lessThanOrEqualTo($nowBerlin)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please select a future date and time for the reminder.'
                ]);
            }

            // Handle attachments
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                }
            }
            $attachments = implode(',', $attachments);
            $doctor_name = Auth::user()->first_name . ' ' . Auth::user()->last_name;

            $details = [
                'subject'      => 'Reminder: Task for Patient: ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                'title'        => 'Reminder: Task for Patient: ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                'patient_name' => $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                'comment'      => $request->comment,
                'doctor_name'  => $doctor_name,
                'attachments'  => $attachments,
                'email'        => $treatment_plan->doctor_email,
            ];
            // Dispatch job
            SendReminderMailJob::dispatch($details)->delay($reminderDateTime);

            return response()->json([
                'success' => true,
                'message' => 'Reminder scheduled successfully!'
            ]);
        }

    // Done By Parth
    public function approveCase(Request $request)
    {
        $data = $request->all();
        unset(
            $data['attachments'],
        );

        $treatment_plan_id = $request->post('treatment_plan_id');
        $comment = $request->post('comment');
        $treatment_plan = DB::table('p_treatment_plans as tp')
            ->where('tp.id', $treatment_plan_id)
            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", "=", "p.id")
                    ->where("p.is_deleted", 0);
            })
            ->Join("users as u", function ($join) {
                $join->on("p.user_id", "=", "u.id");
            })
            ->select("tp.*", "p.id as patientId", "p.user_id", "p.first_name", "p.last_name", "u.email as doctor_email", "p.pricing_package", "p.confidence_package_duration", "p.id as patientId")
            ->first();

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Generate a unique file name or use the original name
                $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                //  $attachments[]=asset('storage/' . $filename);
                // Move the file to the desired directory (e.g., 'uploads')
                $file->storeAs('public/attachments', $filename);
                $attachments[] = $filename;
                $data['attachments'][] = $filename;
            }
        }
        $attachments = implode(',', $attachments);

        if (@$treatment_plan) {

            $order_id = @DB::table('orders')->where('treatment_plan_id', $treatment_plan_id)->where('is_deleted', 0)->first()->id;

            if (@$order_id) {
                $task = new TaskService($treatment_plan_id);
                $task->complete_task("doctor", $treatment_plan->user_id);
                $staffid = DB::table('users')->where('last_name', 'devStaff')->pluck('id')->first();

                $task->create_task("staff", 'Doctor Approved', null, $comment, "doctor", "staff", $attachments); //comment from doctor to staff
                $task_id = DB::table('tasks')->where('treatment_plan_id', $treatment_plan->id)->orderBy('id', 'desc')->first();
                if ($task_id != null) {

                    $calculation = new \App\Http\Services\PriceCalculation();
                    $amount = $calculation->calc(Auth::user()->tier, $treatment_plan);
                    $timestamp = date("Y-m-d H:i:s");

                    DB::table('orders')->where('id', $order_id)->update([
                        "deposit" => $amount,
                        "datetime" => $timestamp,
                        "status" => 'completed'
                    ]);
                    $tasks = DB::table('tasks')
                        ->where('treatment_plan_id', $treatment_plan->id)
                        ->where('type', 'doctor')
                        ->where('status', '!=', 'completed')
                        ->orderByDesc('id')
                        ->get();

                    foreach ($tasks as $task) {
                        DB::table('tasks')->where('id', $task->id)->update([
                            "status" => 'Doctor Approved',
                            "user_id" => Auth::id(),
                        ]);
                    }

                    $treatment_plan_duration = $this->treatment_plan_duration($timestamp, $treatment_plan->aligner_steps, $treatment_plan->phase, $treatment_plan->pricing_package, $treatment_plan->patient_id, $treatment_plan->confidence_package_duration);

                    $task_id = DB::table('tasks')->where('treatment_plan_id', $treatment_plan->id)->orderBy('id', 'desc')->first();

                    if ($task_id != null) {
                        DB::table('patients')->where('id', $treatment_plan->patientId)->update([
                            "is_setup_type_approved" => 2,
                        ]);
                        DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
                            "is_completed" => 1,
                            "is_approved" => 1,
                            "completed_at" => $timestamp,
                            "setup_approval_date" => $timestamp,
                            "treatment_plan_duration" => $treatment_plan_duration,
                            "status" => "Treatment Plan Approved", //"Dr. requests a Modification to Setup ". $treatment_plan->phase,
                            "case_holder" => "staff",
                            "previous_case_holder" => "doctor",
                        ]);
                    }
                    $patient_id = $treatment_plan->patient_id;
                    $doctor_id = DB::table('patients')->where('id', $patient_id)->first();
                    $routes = DB::table('users')->where('id', $doctor_id->user_id)->pluck("email")->toArray();

                    $details = [
                        'subject' => 'Action Required: Treatment Plan Approved for Patient: ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                        'title' => 'Action Required: Treatment Plan Approved for Patient: ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                        'patient_name' => $treatment_plan->first_name." ".$treatment_plan->last_name,
                        'comment' => $comment,
                        'attachments' => $attachments,
                        'email' => $treatment_plan->doctor_email,
                    ];
                    $staff = DB::table('users')
                                ->where('role', 'staff')
                                ->get(['first_name', 'last_name', 'email'])
                                ->toArray();


                    ApproveCaseByDoctorToStaffJob::dispatch($staff, $details);
                    unset(
                        $data['_token'],
                        $data['treatment_plan_id'],
                    );

                    $objAudittrails = new AuditTrails();
                    $saveAudittrails = $objAudittrails->addAudittrails( $treatment_plan->patientId, $request->post('treatment_plan_id'), "Doctor Approved the Case and Sent It to Staff", 'D', 'S', $data);
                    // return redirect('/patients/view')->with('success', 'Case Approved');
                }
            }
        }
        return response()->json();
    }

    protected function treatment_plan_duration($timestamp, $steps, $phase, $pricing_package, $patient_id, $confidence_package_duration)
    {
        if ($pricing_package == 'AL-SECRET-CONFIDENCE') { //3 years duration fixed for all cases
            if ($phase == 1) {
                $currentTimestamp = $timestamp;
                $currentDateTime = new DateTime($currentTimestamp);
                $currentDateTime->modify('+3.5 years');
                $threeYearsLaterTimestamp = $currentDateTime->format('Y-m-d H:i:s');
                DB::table('patients')->where('id', $patient_id)->update([
                    "confidence_package_duration" => $threeYearsLaterTimestamp,
                ]);
                return $threeYearsLaterTimestamp;
            }
            return $confidence_package_duration;
        }
        $additional_time = 12;
        if ($steps > 20) {
            $additional_time = 24;
        }
        // if ($phase > 1) {
        //     $additional_time = 12;
        // }
        // Assuming you have the date completed in the format Y-m-d H:i:s
        $dateCompleted = $timestamp;
        $periodInWeeks = ($steps * 2) + $additional_time;

        // Create a DateTime object for the date completed
        $dateTime = new DateTime($dateCompleted);

        // Calculate the number of days equivalent to the given number of weeks
        $periodInDays = $periodInWeeks * 7;

        // Create a DateInterval object for the specified number of days
        $interval = new DateInterval('P' . $periodInDays . 'D');

        // Add the interval to the original date
        $dateTime->add($interval);

        // Format the resulting date
        $duration = $dateTime->format('Y-m-d H:i:s');

        // Output the duration
        return $duration;
    }

    public function print_picture($patient_id, $file_name)
    {
        $patient_id = $this->hashids->decode($patient_id)[0];
        return view("patients.print_picture", compact("patient_id", "file_name"));
    }
    public function print_images($treatment_plan_id)
    {
        $treatment_plan = DB::table('p_treatment_plans as tp')
            ->where('tp.id', $this->hashids->decode($treatment_plan_id)[0])
            ->whereNotNull("tp.fl_profile")
            ->whereNotNull("tp.fl_front")
            ->whereNotNull("tp.fl_smile")
            ->whereNotNull("tp.fl_upper_occlusal")
            ->whereNotNull("tp.fl_lower_occlusal")
            ->whereNotNull("tp.fl_right_buccal")
            ->whereNotNull("tp.fl_left_buccal")
            ->whereNotNull("tp.fl_frontal")
            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", "=", "p.id")
                    ->where("p.is_deleted", 0);
            })
            ->Join("users as u", function ($join) {
                $join->on("p.user_id", "=", "u.id");
            })
            ->select(
                "tp.fl_profile",
                "tp.fl_front",
                "tp.fl_smile",
                "tp.fl_upper_occlusal",
                "tp.fl_lower_occlusal",
                "tp.fl_right_buccal",
                "tp.fl_frontal",
                "tp.fl_left_buccal",
                "tp.patient_id",
                "p.first_name as p_first_name",
                "p.last_name as p_last_name",
                "u.first_name as d_first_name",
                "u.last_name as d_last_name",
                "p.pricing_package",
            )
            ->first();
        if (@$treatment_plan) {
            return view("patients.print_images_landscape", compact("treatment_plan"));
        }
        abort(404, "Page not found");
    }
    public function edit_image(Request $request, $treatment_plan_id)
    {
        $treatment_plan = DB::table('p_treatment_plans as tp')
            ->where('tp.id', $this->hashids->decode($treatment_plan_id))
            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", "=", "p.id")
                    ->where("p.is_deleted", 0);
            })
            ->Join("users as u", function ($join) {
                $join->on("p.user_id", "=", "u.id");
            })
            ->select(
                "tp.fl_profile",
                "tp.fl_front",
                "tp.fl_smile",
                "tp.fl_upper_occlusal",
                "tp.fl_lower_occlusal",
                "tp.fl_right_buccal",
                "tp.fl_frontal",
                "tp.fl_left_buccal",
                "tp.patient_id",
                "tp.id",
                "p.first_name as p_first_name",
                "p.last_name as p_last_name",
                "u.first_name as d_first_name",
                "u.last_name as d_last_name",
                "p.pricing_package",
            )
            ->first();
        if (@$treatment_plan) {
            $file = @$request->get('file');
            $type = @$request->get('type');
            if ($file) {
                $directory = storage_path('/PatientFiles/Patient' . $treatment_plan->patient_id);
                if ($type == 'history') {
                    $directory = storage_path('/PatientFiles/Patient' . $treatment_plan->patient_id . '/Documentation');
                }
                if (File::exists($directory . '/' . $file)) {
                    $ext = explode(".", $file)[1];
                    return view("patients.edit_image", compact("file", "ext", "treatment_plan", "type"));
                }
            }
        }
        abort(404, "page not found");
    }
    public function update_image(Request $request, $treatment_plan)
    {
        $treatment_plan = DB::table('p_treatment_plans as tp')
            ->where('tp.id', $treatment_plan)
            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", "=", "p.id")
                    ->where("p.is_deleted", 0);
            })
            ->Join("users as u", function ($join) {
                $join->on("p.user_id", "=", "u.id");
            })
            ->select(
                "tp.fl_profile",
                "tp.fl_front",
                "tp.fl_smile",
                "tp.fl_upper_occlusal",
                "tp.fl_lower_occlusal",
                "tp.fl_right_buccal",
                "tp.fl_frontal",
                "tp.fl_left_buccal",
                "tp.patient_id",
                "p.first_name as p_first_name",
                "p.last_name as p_last_name",
                "u.first_name as d_first_name",
                "u.last_name as d_last_name",
                "p.pricing_package",
            )
            ->first();
        if (@$treatment_plan) {
            $type = $request->post('type');
            // Check if the 'croppedImage' file was uploaded
            if ($request->hasFile('croppedImage')) {
                $file = $request->file('croppedImage');

                // Generate a unique file name
                $fileName = $request->post('file_name');

                $directory = storage_path('/PatientFiles/Patient' . $treatment_plan->patient_id);
                if ($type == 'history') {
                    $directory = storage_path('/PatientFiles/Patient' . $treatment_plan->patient_id . '/Documentation');
                }
                if (File::exists($directory . '/' . $file)) {
                    unlink($directory . '/' . $file);
                }

                // Move the uploaded file to the specified directory
                if ($file->move($directory, $fileName)) {
                    // File upload successful
                    return response()->json(1);
                }
            }
        }
        return response()->json(0);
    }
    public function change_pricing_package_admin(Request $request)
    {
        if ( Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' ) {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->where('tp.is_submitted', 1)
                ->where('tp.is_completed', 0)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.user_id", "p.pricing_package")
                ->first();

            if (@$treatment_plan) {
                if (!DB::table('p_treatment_plans')->where('patient_id', $treatment_plan->patient_id)->where('phase', '>', $treatment_plan->phase)->exists()) {
                    DB::table('patients')->where('id', $treatment_plan->patient_id)->update([
                        "pricing_package" => $treatment_plan->pricing_package == 'AL-SECRET-CONFIDENCE' ? 'AL-SECRET-SELECT' : 'AL-SECRET-CONFIDENCE',
                    ]);
                    return response()->json(["status" => 200]);
                }
            }
        }
        return response()->json(["status" => 400]);
    }
    public function change_pricing_package(Request $request)
    {
        if (Auth::user()->role == 'doctor') {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->where('tp.is_submitted', 1)
                ->where('tp.is_completed', 0)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.user_id", "p.pricing_package")
                ->first();
            if (@$treatment_plan) {
                if (!DB::table('p_treatment_plans')->where('patient_id', $treatment_plan->patient_id)->where('phase', '>', $treatment_plan->phase)->exists()) {
                    DB::table('patients')->where('id', $treatment_plan->patient_id)->update([
                        "pricing_package" => $treatment_plan->pricing_package == 'AL-SECRET-CONFIDENCE' ? 'AL-SECRET-SELECT' : 'AL-SECRET-CONFIDENCE',
                    ]);
                    return response()->json(["status" => 200]);
                }
            }
        }
        return response()->json(["status" => 400]);
    }
    public function patient_alert(Request $request)
    {
        if (Auth::user()->role == 'doctor') {
            $request->validate([
                'email' => 'required|email',
                'patient_link' => 'required|url',
            ], [
                'email.required' => 'The patient\'s email is required.',
                'email.email' => 'Please provide a valid email address.',
                'patient_link.required' => 'The Nemolink URL is required.',
                'patient_link.url' => 'Please provide a valid URL.',
            ]);

            $email = $request->post('email');
            $url = $request->post('patient_link');
            $doctor_name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            $doctor_email = Auth::user()->email;
            $patient = DB::table('patients')->where('id', $request->patient_id)->first();
            $patient_name = $patient->first_name . ' ' . $patient->last_name;

            $send_mail = (new MailService())->mailPatient($email, $url, $doctor_name);

            $confirmation_mail = (new DoctorMailService())->mailDoctor($doctor_email, $email, $patient_name);
            return redirect()->back()->with('success', 'Email has been sent');
        }
        return response()->json(["status" => 400]);
    }
    public function update_links(Request $request, $treatment_plan_id)
    {
        DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
            "iframe_link" => $request->input('nemolink'),
            "tracking_id" => $request->input('tracking_nr'),
            "shipping_date_time" => date("Y-m-d H:i:s"),
        ]);
        return redirect()->back()->with('success', 'Links updated');
    }

    public function send_from_doctor_to_staff_for_advisor(Request $request)
    {
        DB::BeginTransaction();
        if (Auth::user()->role == 'doctor') {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $advisor_id = $request->post('advisor');

            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.user_id", "p.pricing_package")
                ->first();
            if ($advisor_id != null) {
                DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                    "recommended_advisor" => $advisor_id
                ]);
            }



            if (@$treatment_plan->case_holder == 'doctor') {
                $task = (new TaskService($treatment_plan_id));
                $task->complete_task("doctor", $treatment_plan->user_id); //complete doctor task
                $task_id = $task->create_task("staff", "Case Review for Advisor", null, $comment, "doctor", "staff", null); //comment from doctor to staff
                if ($task_id != false) {
                    DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                        "case_holder" => "staff",
                        "previous_case_holder" => "doctor",
                        "is_submitted" => 1,
                        "status" => "Waiting Staff Review for Advisor",
                        "recommended_advisor" => $advisor_id
                    ]);
                }
            }
            DB::commit();
        }
        return redirect()->back()->with('success', 'Requested for advisor');
    }

    public function send_from_staff_to_advisor(Request $request)
    {

        if (Auth::user()->role == 'staff') {
            $treatment_plan_id = $request->post('treatment_plan_id');

            $comment = $request->post('comment');
            $advisor_id = $request->post('advisor');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.user_id", "p.first_name", "p.last_name", "p.pricing_package")
                ->first();
            $routes = DB::table('users')->where('id', $advisor_id)->pluck("email")->toArray();

            \Illuminate\Support\Facades\Notification::route('mail', $routes)
                ->notify(new \App\Notifications\CustomAlert($comment, "New task has been added", [], $treatment_plan->first_name, $treatment_plan->last_name));

            if ($request->post('advisor') == null) {
                return redirect()->back()->with('error', 'Please select an advisor');
            }

            if ($advisor_id != null) {
                DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([

                    "advisor_id" => $advisor_id
                ]);
            } else {
                DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([

                    "advisor_id" => $treatment_plan->recommended_advisor
                ]);
            }
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    //  $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                }
            }
            $attachments = implode(',', $attachments);

            if (@$treatment_plan->case_holder == 'staff') {
                $task = (new TaskService($treatment_plan_id));
                $task->complete_task("staff"); //complete staff task
                $task_id = $task->create_task_withoutMail("advisor", "Case Review for Advisor", $advisor_id, $comment, "staff", "advisor", $attachments); //comment from staff to advisor
                if ($task_id != false) {
                    DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
                        "case_holder" => "advisor",
                        "previous_case_holder" => "staff",
                        "status" => "Waiting for Review from Advisor",
                        // "is_treatment_submitted" => 1,

                        "advisor_id" => $advisor_id
                    ]);
                }
            }
        }
        return redirect()->back()->with('success', 'Case is submiited to advisor for review');
    }

    public function send_to_advisor(Request $request){

        if (Auth::user()->role == 'staff') {
            $treatment_plan_id = $request->post('treatment_plan_id');

            $comment = $request->post('comment');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.user_id", "p.first_name", "p.last_name", "p.pricing_package")
                ->first();
            $advisor_id = $treatment_plan->recommended_advisor;
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    //  $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                }
            }
            $attachments = implode(',', $attachments);
            $adviorDetails = DB::table('users')->where('id', $treatment_plan->recommended_advisor)->select("email", 'first_name', 'last_name')->first();
            $details = [
                'subject' => 'Action Required: New task has been added for Patient ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                'title' => 'Action Required: New task has been added for Patient ' . $treatment_plan->first_name . ' ' . $treatment_plan->last_name,
                'patient_name' => $treatment_plan->first_name." " . $treatment_plan->last_name,
                'comment' => $comment,
                'advior_name' => $adviorDetails->first_name." " . $adviorDetails->last_name,
                'advior_email' => $adviorDetails->email,
                'attachments' => $attachments,
            ];
            SendToAdvisorFromStaffJob::dispatch($details);
            // dd("Hello");
            // \Illuminate\Support\Facades\Notification::route('mail', $routes)
            //     ->notify(new \App\Notifications\CustomAlert($comment, "New task has been added", [], $treatment_plan->first_name, $treatment_plan->last_name));
            if (@$treatment_plan->case_holder == 'staff') {
                $task = (new TaskService($treatment_plan_id));
                $task->complete_task("staff"); //complete staff task
                $task_id = $task->create_task_withoutMail("advisor", "Case Review for Advisor", $advisor_id, $comment, "staff", "advisor", $attachments); //comment from staff to advisor
                if ($task_id != false) {
                    DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
                        "case_holder" => "advisor",
                        "previous_case_holder" => "staff",
                        "status" => "Waiting for Review from Advisor",
                    ]);
                }
                return response()->json(['message' => 'Case is submiited to advisor for review.'], 200);
            }
            return response()->json(['message' => 'Case is submiited to advisor for review.'], 200);
        }
        return response()->json(['error' => 'Invalid action.'], 400);
    }

    public function send_from_advisor_to_doctor(Request $request)
    {
        if (Auth::user()->role == 'advisor') {
            $treatment_plan_id = $request->post('treatment_plan_id');
            $comment = $request->post('comment');
            $treatment_plan = DB::table('p_treatment_plans as tp')
                ->where('tp.id', $treatment_plan_id)
                ->Join("patients as p", function ($join) {
                    $join->on("tp.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("tp.*", "p.user_id", "p.pricing_package", "tp.recommended_advisor")
                ->first();

            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique file name or use the original name
                    $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    // $attachments[]=asset('storage/' . $filename);
                    // Move the file to the desired directory (e.g., 'uploads')
                    $file->storeAs('public/attachments', $filename);
                    $attachments[] = $filename;
                }
            }
            $attachments = implode(',', $attachments);
            if (@$treatment_plan->case_holder == 'advisor') {
                $task = (new TaskService($treatment_plan_id));
                $task->complete_task("advisor", $treatment_plan->advisor_id); //complete advisor task
                $task_id = $task->create_task("staff", "Response from advisor", $treatment_plan->user_id, $comment, "advisor", "doctor", $attachments); //comment from advisor to dcotor
                if ($task_id != false) {
                    DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                        "case_holder" => "staff",
                        "previous_case_holder" => "advisor",
                        "status" => "Response from advisor",
                        // "recommended_advisor" => null
                    ]);
                }
            }
        }
    }

     public function openNemoLink(Request $request, $id)
    {

        $decoded = $this->hashids->decode($id);
        if (empty($decoded)) {
            abort(404, 'Invalid patient identifier!');
        }

        $patientId = $decoded[0];
        $patient = DB::table('patients')->where('id', $patientId)->first();
        if (!$patient) {
            return redirect()->back()->with('error','Patient not found');
        }
        if(!$patient->nemotech_patient_id){
            return redirect()->back()->with('error','Patient nemotech id not found');
        }
        $plan = DB::table('p_treatment_plans')->where('patient_id', $patientId)->orderByDesc('id')->first();
        $option = $request->query('type', 'view');
        $nemoService = new NemoTechService($patient->first_name,$patient->last_name,$patient->dob,$patient->user_id);
        $jwtToken = $nemoService->getSecretToken($patient->nemotech_patient_id,$plan->phase);
        $messages = [
            1 => 'API Authentication Failed!',
            2 => 'Patient details not found!',
            3 => 'Patient document not found. Please link add manually!',
            4 => 'Patient document links not found!',
        ];

        if (in_array($jwtToken, [1, 2, 3, 4])) {
            return redirect()->back()->with('error', $messages[$jwtToken]);
        }
        if (!$plan) {
            return redirect()->back()->with('error','patient shared document not found');
        }

        $finalLink = null;
        if ($option == 'edit') {
            $finalLink = $jwtToken['link'] ?? null;
        } else {
            $finalLink = $jwtToken['doctorSharedLink'] ?? null;
        }

        $iframeLink = Str::replace('downloads-default', 'downloads-secretalign',$finalLink);
        $patientLink = Str::replace('downloads-default', 'downloads-secretalign',$jwtToken['patientSharedLink']);

        DB::table('p_treatment_plans')->where('id', $plan->id)
        ->update([
            'iframe_link'        => $iframeLink,
            'patient_link'      => $patientLink,
            'link_type' => $option,
        ]);

        return redirect()->back()->with('success','patient document synced successfully');
    }

    public function load($patientId){
        $plan = DB::table('p_treatment_plans')->where('id', $patientId)->orderByDesc('id')->first();
        return redirect()->away($plan->iframe_link);
    }
}
