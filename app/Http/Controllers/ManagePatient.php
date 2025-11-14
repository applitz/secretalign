<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;

class ManagePatient extends Controller
{
    public $hashids;
    public function __construct()
    {
        $this->middleware('auth');
        $this->hashids = new Hashids();
        View::share("hashids", $this->hashids);
    }
    public function secret_partner_requests(Request $request)
    {
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')) {
            abort(403, "unauthorized request");
        }
        $whereClauses = [
            ["p.is_deleted", 0],
        ];
        $partner = @$request->get('partner');

        $date = @$request->get('date');
        // if (!empty($date)) {
        //     if (str_contains($date, 'to')) {
        //         $date = \explode('to', $date);
        //         $start = trim($date[0]);
        //         $end = trim($date[1]);
        //         array_push($whereClauses, ['p.created_at', '>=', date('Y-m-d', strtotime($start)) . ' 00:00:00']);
        //         array_push($whereClauses, ['p.created_at', '<=', date('Y-m-d', strtotime($end)) . ' 23:59:59']);
        //     } else {
        //         array_push($whereClauses, ['p.created_at', '>=', date('Y-m-d', strtotime($date)) . ' 00:00:00']);
        //         array_push($whereClauses, ['p.created_at', '<=', date('Y-m-d', strtotime($date)) . ' 23:59:59']);
        //     }
        // }
        $search = @$request->get('search');
        $orderBy = @$request->get('orderBy');
        $col = @$request->get('col');
        if (empty($orderBy) || empty($col)) {
            $orderBy = 'desc';
            $col = 'tp.id';
        }

        $patients = DB::table('patients as p')

            ->where($whereClauses)
            ->whereNotNull('p.first_name')
            ->leftJoin('p_treatment_plans as tp', function ($join) {
                $join->on('p.id', '=', 'tp.patient_id')
                    ->where('tp.is_deleted', 0)
                    ->whereRaw('tp.id =
                                  (select max(id) from p_treatment_plans
                                   where patient_id = p.id)');
            })
            ->Join("users as u", function ($join) use ($partner) {
                $join->on("u.id", "=", "p.user_id");
                if (!empty($partner)) {
                    $join->where('u.registered_by', $partner);
                }
            })
            ->Join("users as r", function ($join) {
                $join->on("r.id", "=", "u.registered_by");
            })
            ->leftJoin("users as l", function ($join) {
                $join->on("tp.lab", "=", "l.id")
                    ->where("l.role", "lab");
            })
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
            ->select(
                'p.*',
                'tp.is_submitted',
                'tp.phase',
                'tp.id as treatment_plan',
                "tp.status",
                'u.first_name as d_first_name',
                'u.last_name as d_last_name',
                "r.first_name as r_first_name",
                "r.last_name as r_last_name",
                "tp.is_completed",
                "tp.completed_at",
                "tp.treatment_plan_duration",
                "tp.cancellation_date",
                "tp.setup_approval_date",
                "l.first_name as lab_first_name",
                "l.last_name as lab_last_name",
            )
            ->orderBy($col, $orderBy)
            ->paginate(20);
        $patients->appends([
            "search" => $search,
            "date" => $date,
            "partner" => $partner,
            "orderBy" => $orderBy,
            "col" => $col,
        ]);
        $doctors = [];
        $partners = DB::table('users')
            ->where('role', 'rep')
            ->get();
        return view("patients.view_partner_requests", compact("patients", "partners"));
    }
    public function view(Request $request)
    {
        $whereClauses = [
            ["p.is_deleted", 0],
        ];
        $doctor = @$request->get('doctor');
        if (Auth::user()->role == 'doctor') {
            array_push($whereClauses, ["p.user_id", Auth::user()->id]);
        }else if (Auth::user()->role == 'advisor') {
            array_push($whereClauses, ["tp.recommended_advisor", Auth::user()->id]);
        } else {
            if (!empty($doctor)) {
                array_push($whereClauses, ['p.user_id', $doctor]);
            }
        }

        $date = @$request->get('date');
        if (!empty($date)) {
            if (str_contains($date, 'to')) {
                $date = \explode('to', $date);
                $start = trim($date[0]);
                $end = trim($date[1]);
                array_push($whereClauses, ['p.created_at', '>=', date('Y-m-d', strtotime($start)) . ' 00:00:00']);
                array_push($whereClauses, ['p.created_at', '<=', date('Y-m-d', strtotime($end)) . ' 23:59:59']);
            } else {
                array_push($whereClauses, ['p.created_at', '>=', date('Y-m-d', strtotime($date)) . ' 00:00:00']);
                array_push($whereClauses, ['p.created_at', '<=', date('Y-m-d', strtotime($date)) . ' 23:59:59']);
            }
        }
        $status = $request->get('status');
        if (!empty($status)) {
            if (strpos($status, "Continuing Treatment") !== false) {
                array_push($whereClauses, ['tp.is_continue', true]);
            }else{
                array_push($whereClauses, ['tp.status', $status]);
            }
        }

        $search = @$request->get('search');
        $orderBy = @$request->get('orderBy');
        $col = @$request->get('col');
        if (empty($orderBy) || empty($col)) {
            $orderBy = 'desc';
            $col = 'tp.id';
        }
        if (Auth::user()->role == 'lab') {
            $patients = DB::table('patients as p')
                ->where($whereClauses)
                ->whereNotNull('p.first_name')
                ->join('p_treatment_plans as tp', function ($join) {
                    $join->on('p.id', '=', 'tp.patient_id')
                        ->where('tp.is_deleted', 0)
                        ->whereRaw('tp.id =
                                  (select max(id) from p_treatment_plans
                                   where patient_id = p.id)');
                    $join->where("tp.lab", Auth::user()->id);
                })
                ->Join("users as u", function ($join) {
                    $join->on("u.id", "=", "p.user_id");
                })
                ->leftJoin("users as l", function ($join) {
                    $join->on("tp.lab", "=", "l.id")
                        ->where("l.role", "lab");
                })
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
                ->select(
                    'p.*',
                    'tp.is_submitted',
                    'tp.phase',
                    'tp.id as treatment_plan',
                    "tp.status",
                    'u.first_name as d_first_name',
                    'u.last_name as d_last_name',
                    "tp.is_completed",
                    "tp.completed_at",
                    "tp.treatment_plan_duration",
                    "l.first_name as lab_first_name",
                    "l.last_name as lab_last_name",
                )
                ->orderBy($col, $orderBy)
                ->paginate(20)->appends(request()->query());
            $patients->appends([
                "search" => $search,
                "date" => $date,
                "doctor" => $doctor,
                "orderBy" => $orderBy,
                "col" => $col,
            ]);
            $doctors = [];
            if (Auth::user()->role != 'doctor') {
                $doctors = DB::table('users')->where('role', 'doctor')->get();
            }
            return view("patients.view_patients", compact("patients", "doctors"));
        }

        $patients = DB::table('patients as p')

            ->where($whereClauses)
            ->whereNotNull('p.first_name')
            ->leftJoin('p_treatment_plans as tp', function ($join) {
                $join->on('p.id', '=', 'tp.patient_id')
                    ->where('tp.is_deleted', 0)
                    ->whereRaw('tp.id =
                                  (select max(id) from p_treatment_plans
                                   where patient_id = p.id)');
            })
            ->Join("users as u", function ($join) {
                $join->on("u.id", "=", "p.user_id");
                if(Auth::user()->role == 'rep') {
                    $join->where('u.registered_by', Auth::user()->id);
                }
            })
            ->leftJoin("users as l", function ($join) {
                $join->on("tp.lab", "=", "l.id")
                    ->where("l.role", "lab");
            })
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
            ->select(
                'p.*',
                'tp.is_submitted',
                'tp.phase',
                'tp.id as treatment_plan',
                "tp.status",
                'u.first_name as d_first_name',
                'u.last_name as d_last_name',
                "tp.is_completed",
                "tp.completed_at",
                "tp.treatment_plan_duration",
                "tp.cancellation_date",
                "tp.setup_approval_date",
                "tp.recommended_advisor",
                "l.first_name as lab_first_name",
                "l.last_name as lab_last_name",
            )
            ->orderBy($col, $orderBy)
            ->paginate(20)->appends(request()->query());
        $patients->appends([
            "search" => $search,
            "date" => $date,
            "doctor" => $doctor,
            "orderBy" => $orderBy,
            "col" => $col,
        ]);
        $doctors = [];
        if (Auth::user()->role != 'doctor') {
            $doctors = DB::table('users')
            ->where(function ($query) {
                if(Auth::user()->role == 'rep') {
                    $query->where('registered_by', Auth::user()->id);
                }
            })
            ->where('role', 'doctor')
            ->get();
        }

        $statusOptions = DB::table('p_treatment_plans')
            ->where('is_deleted', 0)
            ->distinct()
            ->pluck('status');
        $count = DB::table('patients as p')->where($whereClauses)
        ->whereNotNull('p.first_name')
        ->leftJoin('p_treatment_plans as tp', function ($join) {
            $join->on('p.id', '=', 'tp.patient_id')
                ->where('tp.is_deleted', 0)
                ->whereRaw('tp.id =
                              (select max(id) from p_treatment_plans
                               where patient_id = p.id)');
        })->where('is_continue', true)->count();

       $statusOptions->push('Continuing Treatment ('.$count.')');
        return view("patients.view_patients", compact("patients", "doctors", "statusOptions"));
    }
    public function under_process(Request $request)
    {
        if(!(Auth::user()->role == 'staff' || Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')) {
            abort(403, "unauthorized request");
        }
        $whereClauses = [
            ["p.is_deleted", 0],
        ];
        $doctor = @$request->get('doctor');
        if (Auth::user()->role == 'doctor') {
            array_push($whereClauses, ["p.user_id", Auth::user()->id]);
        } else {

            if (!empty($doctor)) {
                array_push($whereClauses, ['p.user_id', $doctor]);
            }
        }


        $date = @$request->get('date');
        if (!empty($date)) {
            if (str_contains($date, 'to')) {
                $date = \explode('to', $date);
                $start = trim($date[0]);
                $end = trim($date[1]);
                array_push($whereClauses, ['p.created_at', '>=', date('Y-m-d', strtotime($start)) . ' 00:00:00']);
                array_push($whereClauses, ['p.created_at', '<=', date('Y-m-d', strtotime($end)) . ' 23:59:59']);
            } else {
                array_push($whereClauses, ['p.created_at', '>=', date('Y-m-d', strtotime($date)) . ' 00:00:00']);
                array_push($whereClauses, ['p.created_at', '<=', date('Y-m-d', strtotime($date)) . ' 23:59:59']);
            }
        }
        $search = @$request->get('search');
        $case_holder = @$request->get('case_holder');
        $orderBy = @$request->get('orderBy');
        $col = @$request->get('col');
        if (empty($orderBy) || empty($col)) {
            $orderBy = 'desc';
            $col = 'tp.id';
        }

        $patients = DB::table('patients as p')

            ->where($whereClauses)
            ->whereNotNull('p.first_name')
            ->Join('p_treatment_plans as tp', function ($join) use ($case_holder) {
                $join->on('p.id', '=', 'tp.patient_id')
                    ->where('tp.is_deleted', 0)
                    ->where('tp.is_submitted', 1)
                ->whereNull('tp.tracking_id')
                    ->whereRaw('tp.id =
                                  (select max(id) from p_treatment_plans
                                   where patient_id = p.id)');


                                   if(!empty($case_holder)) {
                                    $join->where('tp.case_holder', $case_holder);
                                   }
            })
            ->Join("users as u", function ($join) {
                $join->on("u.id", "=", "p.user_id");
            })
            ->leftJoin("users as l", function ($join) {
                $join->on("tp.lab", "=", "l.id")
                    ->where("l.role", "lab");
            })
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
            ->select(
                'p.*',
                'tp.is_submitted',
                'tp.phase',
                'tp.id as treatment_plan',
                "tp.status",
                'u.first_name as d_first_name',
                'u.last_name as d_last_name',
                "tp.is_completed",
                "tp.completed_at",
                "tp.treatment_plan_duration",
                "tp.cancellation_date",
                "tp.case_holder",
                "tp.setup_approval_date",
                "l.first_name as lab_first_name",
                "l.last_name as lab_last_name",
            )
            ->orderBy($col, $orderBy)
            ->paginate(20);
        $patients->appends([
            "search" => $search,
            "date" => $date,
            "doctor" => $doctor,
            "orderBy" => $orderBy,
            "col" => $col,
        ]);
        $doctors = [];
        if (Auth::user()->role != 'doctor') {
            $doctors = DB::table('users')->where('role', 'doctor')->get();
        }
        return view("patients.view_patients_under_process", compact("patients", "doctors"));
    }
    public function delivered(Request $request)
    {
        if(!(Auth::user()->role == 'staff' || Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')) {
            abort(403, "unauthorized request");
        }
        $whereClauses = [
            ["p.is_deleted", 0],
        ];
        $doctor = @$request->get('doctor');
        if (Auth::user()->role == 'doctor') {
            array_push($whereClauses, ["p.user_id", Auth::user()->id]);
        } else {

            if (!empty($doctor)) {
                array_push($whereClauses, ['p.user_id', $doctor]);
            }
        }


        $date = @$request->get('date');
        if (!empty($date)) {
            if (str_contains($date, 'to')) {
                $date = \explode('to', $date);
                $start = trim($date[0]);
                $end = trim($date[1]);
                array_push($whereClauses, ['p.created_at', '>=', date('Y-m-d', strtotime($start)) . ' 00:00:00']);
                array_push($whereClauses, ['p.created_at', '<=', date('Y-m-d', strtotime($end)) . ' 23:59:59']);
            } else {
                array_push($whereClauses, ['p.created_at', '>=', date('Y-m-d', strtotime($date)) . ' 00:00:00']);
                array_push($whereClauses, ['p.created_at', '<=', date('Y-m-d', strtotime($date)) . ' 23:59:59']);
            }
        }
        $search = @$request->get('search');

        $orderBy = @$request->get('orderBy');
        $col = @$request->get('col');
        if (empty($orderBy) || empty($col)) {
            $orderBy = 'desc';
            $col = 'tp.id';
        }

        $patients = DB::table('patients as p')
            ->where($whereClauses)
            ->whereNotNull('p.first_name')
            ->Join('p_treatment_plans as tp', function ($join) {
                $join->on('p.id', '=', 'tp.patient_id')
                    ->where('tp.is_deleted', 0)
                    ->whereNotNull('tp.tracking_id');
            })
            ->Join("users as u", function ($join) {
                $join->on("u.id", "=", "p.user_id");
            })
            ->leftJoin("users as l", function ($join) {
                $join->on("tp.lab", "=", "l.id")
                    ->where("l.role", "lab");
            })
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
            ->select(
                'p.*',
                'tp.is_submitted',
                'tp.phase',
                'tp.id as treatment_plan',
                "tp.status",
                'u.first_name as d_first_name',
                'u.last_name as d_last_name',
                "tp.is_completed",
                "tp.completed_at",
                "tp.treatment_plan_duration",
                "tp.cancellation_date",
                "tp.setup_approval_date",
                "tp.tracking_id",
                "l.first_name as lab_first_name",
                "l.last_name as lab_last_name",
            )
            ->orderBy($col, $orderBy)
            ->paginate(20);
        $patients->appends([
            "search" => $search,
            "date" => $date,
            "doctor" => $doctor,
            "orderBy" => $orderBy,
            "col" => $col,
        ]);
        $doctors = [];
        if (Auth::user()->role != 'doctor') {
            $doctors = DB::table('users')->where('role', 'doctor')->get();
        }
        return view("patients.view_patients_delivered", compact("patients", "doctors"));
    }
    public function cancelled(Request $request)
    {
        if(!(Auth::user()->role == 'staff' || Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')) {
            abort(403, "unauthorized request");
        }
        $whereClauses = [
            ["p.is_deleted", 0],
        ];
        $doctor = @$request->get('doctor');
        if (Auth::user()->role == 'doctor') {
            array_push($whereClauses, ["p.user_id", Auth::user()->id]);
        } else {

            if (!empty($doctor)) {
                array_push($whereClauses, ['p.user_id', $doctor]);
            }
        }


        $date = @$request->get('date');
        if (!empty($date)) {
            if (str_contains($date, 'to')) {
                $date = \explode('to', $date);
                $start = trim($date[0]);
                $end = trim($date[1]);
                array_push($whereClauses, ['p.created_at', '>=', date('Y-m-d', strtotime($start)) . ' 00:00:00']);
                array_push($whereClauses, ['p.created_at', '<=', date('Y-m-d', strtotime($end)) . ' 23:59:59']);
            } else {
                array_push($whereClauses, ['p.created_at', '>=', date('Y-m-d', strtotime($date)) . ' 00:00:00']);
                array_push($whereClauses, ['p.created_at', '<=', date('Y-m-d', strtotime($date)) . ' 23:59:59']);
            }
        }
        $search = @$request->get('search');

        $orderBy = @$request->get('orderBy');
        $col = @$request->get('col');
        if (empty($orderBy) || empty($col)) {
            $orderBy = 'desc';
            $col = 'tp.id';
        }

        $patients = DB::table('patients as p')

            ->where($whereClauses)
            ->whereNotNull('p.first_name')
            ->Join('p_treatment_plans as tp', function ($join) {
                $join->on('p.id', '=', 'tp.patient_id')
                    ->where('tp.is_deleted', 0)
                    ->where('tp.is_cancelled', 1)
                    ->orWhere('tp.is_rejected', 1);
            })
            ->Join("users as u", function ($join) {
                $join->on("u.id", "=", "p.user_id");
            })
            ->leftJoin("users as l", function ($join) {
                $join->on("tp.lab", "=", "l.id")
                    ->where("l.role", "lab");
            })
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
            ->select(
                'p.*',
                'tp.is_submitted',
                'tp.phase',
                'tp.id as treatment_plan',
                "tp.status",
                'u.first_name as d_first_name',
                'u.last_name as d_last_name',
                "tp.is_completed",
                "tp.completed_at",
                "tp.treatment_plan_duration",
                "tp.cancellation_date",
                "tp.setup_approval_date",
                "l.first_name as lab_first_name",
                "l.last_name as lab_last_name",
            )
            ->orderBy($col, $orderBy)
            ->paginate(20);
        $patients->appends([
            "search" => $search,
            "date" => $date,
            "doctor" => $doctor,
            "orderBy" => $orderBy,
            "col" => $col,
        ]);
        $doctors = [];
        if (Auth::user()->role != 'doctor') {
            $doctors = DB::table('users')->where('role', 'doctor')->get();
        }
        return view("patients.view_patients_cancelled", compact("patients", "doctors"));
    }
    public function delete($id)
    {

        if (DB::table('patients')->where('id', $id)->exists()) {
            DB::table('patients')->where('id', $id)->update([
                "is_deleted" => 1,
                "deleted_at" => date("Y-m-d H:i:s"),
            ]);
            DB::table('p_treatment_plans')->where('patient_id', $id)->update([
                "is_deleted" => 1,
                "deleted_at" => date("Y-m-d H:i:s"),
            ]);
            Session::flash('success', 'Patient deleted!');
            return \redirect()->back();
        }
        Session::flash('error', 'Patient cannot be deleted!');
        return \redirect()->back();
    }
}
