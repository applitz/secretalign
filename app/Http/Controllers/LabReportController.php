<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;

class LabReportController extends Controller
{
    public $hashids;
    public function __construct()
    {
        $this->middleware(['auth', 'auth.superadmin']);
        $this->hashids = new Hashids();
        View::share("hashids", $this->hashids);
    }
    public function view_lab_requests(Request $request)
    {
        $whereClauses = [];
        $date = @$request->get('date');
        if (!empty($date)) {
            if (str_contains($date, 'to')) {
                $date = \explode('to', $date);
                $start = trim($date[0]);
                $end = trim($date[1]);
                array_push($whereClauses, ['lr.created_at', '>=', date('Y-m-d', strtotime($start)) . ' 00:00:00']);
                array_push($whereClauses, ['lr.created_at', '<=', date('Y-m-d', strtotime($end)) . ' 23:59:59']);
            } else {
                array_push($whereClauses, ['lr.created_at', '>=', date('Y-m-d', strtotime($date)) . ' 00:00:00']);
                array_push($whereClauses, ['lr.created_at', '<=', date('Y-m-d', strtotime($date)) . ' 23:59:59']);
            }
        }
        $lab = @$request->get('lab');
        if (!empty($lab)) {
            array_push($whereClauses, ['lr.user_id', $lab]);
        }
        $requests = DB::table('lab_requests as lr')
            ->where($whereClauses)
            ->Join("users as l", function ($join) {
                $join->on("lr.user_id", "=", "l.id")
                    ->where("l.role", "lab");
            })
            ->Join("p_treatment_plans as tp", function ($join) {
                $join->on("lr.treatment_plan_id", "=", "tp.id")
                    ->where("tp.is_deleted", 0);
            })
            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", "=", "p.id")
                    ->whereNotNull("p.first_name")
                    ->whereNotNull("p.last_name")
                    ->whereNotNull("p.dob");
            })
            ->Join("users as d", function ($join) {
                $join->on("p.user_id", "=", "d.id")
                    ->where("d.role", "doctor");
            })
            ->select(
                "tp.id as plan_id",
                "lr.id as lab_request_id",
                "lr.is_canceled",
                "lr.created_at as requested_at",
                "l.first_name as l_first_name",
                "l.last_name as l_last_name",
                "tp.phase",
                "tp.is_treatment_submitted",
                "p.first_name as p_first_name",
                "p.last_name as p_last_name",
                "d.first_name as d_first_name",
                "d.last_name as d_last_name",
                "p.pricing_package"
            )
            ->orderByDesc("lr.id")
            ->paginate(20);
        $requests->appends([
            "date" => $date,
            "lab" => $lab,
        ]);
        $labs = DB::table('users')->where("role", "lab")->get();
        return view("reports.lab_requests", compact("requests", "labs"));
    }
}
