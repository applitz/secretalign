<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;

class OrderController extends Controller
{
    public $hashids;
    public function __construct()
    {
        $this->middleware(['auth', 'auth.users.controller']);
        $this->hashids = new Hashids();
        View::share("hashids", $this->hashids);
    }
    public function view_orders(Request $request)
    {
        $whereClauses = [
            ['o.is_deleted', 0],
        ];
        $date = @$request->get('date');
        if (!empty($date)) {
            if (str_contains($date, 'to')) {
                $date = \explode('to', $date);
                $start = trim($date[0]);
                $end = trim($date[1]);
                array_push($whereClauses, ['o.datetime', '>=', date('Y-m-d', strtotime($start)) . ' 00:00:00']);
                array_push($whereClauses, ['o.datetime', '<=', date('Y-m-d', strtotime($end)) . ' 23:59:59']);
            } else {
                array_push($whereClauses, ['o.datetime', '>=', date('Y-m-d', strtotime($date)) . ' 00:00:00']);
                array_push($whereClauses, ['o.datetime', '<=', date('Y-m-d', strtotime($date)) . ' 23:59:59']);
            }
        }
        $doctor = @$request->get('doctor');
        if (!empty($doctor)) {
            array_push($whereClauses, ['p.user_id', $doctor]);
        }
        $status = @$request->get('status');
        if (!empty($status)) {
            array_push($whereClauses, ['o.status', $status]);
        }
        $search = @$request->get('search');
        $orders = DB::table('orders as o')
            ->where($whereClauses)
            ->Join("patients as p", function ($join) {
                $join->on("o.patient_id", "=", "p.id")
                    ->where('p.is_deleted', 0)
                    ->whereNotNull("p.first_name")
                    ->whereNotNull("p.last_name")
                    ->whereNotNull("p.dob");
            })
            ->Join("p_treatment_plans as tp", function ($join) use ($request) {
                $join->on("o.treatment_plan_id", "=", "tp.id")
                    ->where("tp.is_deleted", 0);
                    // if ($request->status == 'pending') {
                    //     $join->where('tp.is_completed', 0);
                    // }
                    // if ($request->status == 'completed') {
                    //     $join->where('tp.is_completed', 1);
                    // }
            })
            ->Join("users as u", function ($join) {
                $join->on("u.id", "=", "o.user_id");
                if (Auth::user()->role == 'rep') {
                    $join->where('u.registered_by', Auth::user()->id);
                }
            })
            ->where(function ($query) use ($search) {
                if (!empty($search)) {
                    $query->where('u.first_name', 'like', '%' . $search . '%')
                        ->orWhere('u.last_name', 'like', '%' . $search . '%')
                        ->orWhere('p.first_name', 'like', '%' . $search . '%')
                        ->orWhere('p.last_name', 'like', '%' . $search . '%');
                }
            })
            ->select(
                "o.*",
                "u.first_name",
                "u.last_name",
                "u.billing_address",
                "u.shipping_address",
                "u.email",
                "u.phone_number",
                "p.first_name as p_first_name",
                "p.last_name as p_last_name",
                "tp.is_completed",
                "tp.tracking_id"
            )
            ->orderByDesc("o.id")
            ->paginate(20)->appends(request()->query());
        $orders->appends([
            "search" => $search,
            "date" => $date,
            "doctor" => $doctor,
        ]);
       // dd($orders);

        $statusOptions = DB::table('orders')
            ->where('is_deleted', 0)
            ->distinct()
            ->pluck('status');

        $doctors = DB::table('users')->where('role', 'doctor')->get();
       // dd($orders);
        return view("patients.view_orders", compact("orders", "doctors", "statusOptions"));
    }
    public function print_order(Request $request, $id)
    {
        $order = DB::table('orders as o')
            ->where("o.is_deleted", 0)
            ->where("o.id", $this->hashids->decode($id))
            ->Join("patients as p", function ($join) {
                $join->on("o.patient_id", "=", "p.id")
                    ->where('p.is_deleted', 0)
                    ->whereNotNull("p.first_name")
                    ->whereNotNull("p.last_name")
                    ->whereNotNull("p.dob");
            })
            ->Join("p_treatment_plans as tp", function ($join) {
                $join->on("o.treatment_plan_id", "=", "tp.id")
                    //->where('tp.is_completed', 1)
                    ->where("tp.is_deleted", 0);
            })
            ->Join("users as u", function ($join) {
                $join->on("u.id", "=", "o.user_id");
            })
            ->Join("tiers as t", function ($join) {
                $join->on("u.tier", "=", "t.id");
            })
            ->select(
                "o.*",
                "u.first_name",
                "u.last_name",
                "u.billing_address",
                "u.shipping_address",
                "u.email",
                "u.phone_number",
                "p.first_name as p_first_name",
                "p.last_name as p_last_name",
                "tp.treat_upper_arch",
                "tp.treat_lower_arch",
                "tp.aligner_steps",
                "tp.phase",
                "t.tier_name",
                "tp.is_completed",
            )
            ->first();
          // dd($order);
        if (@$order) {
            if ($request->get('view') == 'print') {
                return view("patients.print_order", compact("order"));
            }
            return view("patients.view_order", compact("order"));
        }
    }
}
