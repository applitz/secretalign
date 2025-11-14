<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;

class FinishedOrders extends Controller
{
    public $hashids;
    public function __construct()
    {
        $this->middleware('auth');
        $this->hashids = new Hashids();
        View::share("hashids", $this->hashids);
    }
    public function finished_orders(Request $request)
    {
        if(Auth::user()->role == 'staff' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin') {
            $doctor = @$request->get('doctor');
            $orders = DB::table('p_treatment_plans as tp')
            ->where('tp.is_completed', 1)
            ->whereNotNull("tp.tracking_id")
            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", "=", "p.id")
                    ->where("p.is_deleted", 0);
            })
            ->Join("users as d", function ($join) use ($doctor) {
                $join->on("p.user_id", "=", "d.id");
                if($doctor != "") {
                    $join->where("d.id", $doctor);
                }
            })
            ->select("tp.*", "p.user_id", "p.pricing_package", "p.first_name as p_first_name", "p.last_name as p_last_name", "d.first_name as d_first_name", "d.last_name as d_last_name")
            ->orderBy('id', 'desc')
            ->paginate(20);
            $doctors = DB::table('users')->where('role', 'doctor')->orderBy('id', 'desc')->get();
            return view("patients.finished_orders", compact("orders", "doctors"));
        }
        abort(403, "page not found");
    }
}
