<?php

namespace App\Http\Controllers;

use App\Models\DoctorClinicalPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class PatientMailOverview extends Controller
{
    public $hashids;
    public function __construct()
    {

        $this->hashids = new Hashids();
        View::share("hashids", $this->hashids);
    }

    public function mailiframe(Request $request, $phase)
    {
        try {
            $phase = Crypt::decryptString($phase);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(403, 'Unauthorized request!');
        }

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
            // $notificationId = @$request->get('notify');
            // if (!empty($notificationId)) {
            //     if (DB::table('notifications')->where('treatment_plan_id', $phase)->where('user_id', Auth::user()->id)->where('id', $notificationId)->whereNull('read_at')->exists()) {
            //         DB::table('notifications')->where('id', $notificationId)->update([
            //             "read_at" => date("Y-m-d H:i:s"),
            //         ]);
            //     }
            // }
            return view("patients.case_iframe", $data);
        }
        abort(403, 'Unauthorized request!');
    }
}
