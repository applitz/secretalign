<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;

class TaskController extends Controller
{
    public $hashids;
    public function __construct()
    {
        $this->middleware('auth');
        $this->hashids = new Hashids();
        View::share('hashids', $this->hashids);
    }
    public function cancelled_tasks()
    {
        $data = [];
        if (Auth::user()->role == 'staff' || Auth::user()->role == 'lab' || Auth::user()->role == 'doctor') {
            $whereClauses = [
                ['tp.is_cancelled', 1],
            ];
            if (Auth::user()->role == 'doctor' || Auth::user()->role == 'lab') {
                array_push($whereClauses, ['t.user_id', Auth::user()->id]);
            }
            $tasks = DB::table('tasks as t')
                ->where($whereClauses)
                ->join('p_treatment_plans as tp', function ($join) {
                    $join->on('t.treatment_plan_id', '=', 'tp.id')
                        ->where('tp.is_deleted', 0);
                })
                ->join('patients as p', function ($join) {
                    $join->on('p.id', '=', 'tp.patient_id')
                        ->where('p.is_deleted', 0);
                })
                ->join('users as u', function ($join) {
                    $join->on('u.id', '=', 'p.user_id');
                })
                ->select(
                    't.*',
                    'u.first_name',
                    'u.last_name',
                    'tp.phase',
                    'tp.cancellation_date',
                    'p.first_name as p_first_name',
                    'p.last_name as p_last_name',
                    'tp.previous_case_holder'
                )
                ->orderByDesc('t.created_at')
                ->paginate(20);
            // $tasks = DB::table('tasks as t')
            //     ->where($whereClauses)
            //     ->Join("p_treatment_plans as tp", function ($join) {
            //         ->where('tp.is_deleted', 0);
            //         $join->on("t.treatment_plan_id", "=", "tp.id")
            //     })
            //     ->Join("patients as p", function ($join) {
            //         $join->on("p.id", "=", "tp.patient_id")
            //             ->where('p.is_deleted', 0);
            //     })
            //     ->Join("users as u", function ($join) {
            //         $join->on("u.id", "=", "p.user_id");
            //     })
            //     ->select(
            //         "t.*",
            //         "u.first_name",
            //         "u.last_name",
            //         "tp.phase",
            //         "tp.cancellation_date",
            //         "p.first_name as p_first_name",
            //         "p.last_name as p_last_name",
            //         "tp.previous_case_holder",
            //     )
            //     ->orderByDesc("t.created_at")
            //     ->paginate(20);
            $data = [
                "tasks" => $tasks,
            ];
        }
        return view("users.view_tasks2", $data);
    }
    public function tasks()
    {
        $data = [];
        if (Auth::user()->role == 'staff' || Auth::user()->role == 'lab' || Auth::user()->role == 'doctor') {
            $whereClauses = [
                ['t.status', '!=', 'completed'],
                ['t.type', Auth::user()->role],
            ];
            if (Auth::user()->role == 'doctor' || Auth::user()->role == 'lab') {
                array_push($whereClauses, ['t.user_id', Auth::user()->id]);
            }
            $tasks = DB::table('tasks as t')
                ->where($whereClauses)
                ->Join("p_treatment_plans as tp", function ($join) {
                    $join->on("t.treatment_plan_id", "=", "tp.id")
                        ->where('tp.is_deleted', 0);
                })
                ->Join("patients as p", function ($join) {
                    $join->on("p.id", "=", "tp.patient_id")
                        ->where('p.is_deleted', 0);
                })
                ->Join("users as u", function ($join) {
                    $join->on("u.id", "=", "p.user_id");
                })
                ->select(
                    "t.*",
                    "u.first_name",
                    "u.last_name",
                    "tp.phase",
                    "tp.cancellation_date",
                    "p.first_name as p_first_name",
                    "p.last_name as p_last_name",
                    "tp.previous_case_holder",
                )
                ->orderByDesc("t.created_at")
                ->paginate(20);
            $data = [
                "tasks" => $tasks,
            ];
        }
        return view("users.view_tasks2", $data);
    }
    public function view(Request $request)
    {
        $data = [];
        $taskId = @$request->get('task');
        $notificationId = @$request->get('notify');
        if (Auth::user()->role == 'staff' || Auth::user()->role == 'lab' || Auth::user()->role == 'doctor') {
            $whereClauses = [
                ['t.status', '!=', 'completed'],
                ['t.type', Auth::user()->role],
            ];
            if (Auth::user()->role == 'doctor' || Auth::user()->role == 'lab') {
                array_push($whereClauses, ['t.user_id', Auth::user()->id]);
            }
            if (!empty($taskId) && !empty($notificationId)) {
                array_push($whereClauses, ["t.id", $taskId]);
                if (DB::table('notifications')->where('task_id', $taskId)->where('user_id', Auth::user()->id)->where('id', $notificationId)->whereNull('read_at')->exists()) {
                    DB::table('notifications')->where('id', $notificationId)->update([
                        "read_at" => date("Y-m-d H:i:s"),
                    ]);
                }
            }
            $tasks = DB::table('tasks as t')
                ->where($whereClauses)
                ->Join("p_treatment_plans as tp", function ($join) {
                    $join->on("t.treatment_plan_id", "=", "tp.id")
                        ->where('tp.is_deleted', 0);
                })
                ->Join("patients as p", function ($join) {
                    $join->on("p.id", "=", "tp.patient_id")
                        ->where('p.is_deleted', 0);
                })
                ->Join("users as u", function ($join) {
                    $join->on("u.id", "=", "p.user_id");
                })
                ->select(
                    "t.*",
                    "u.first_name",
                    "u.last_name",
                    "tp.phase",
                    "tp.previous_case_holder",
                    "p.pricing_package",
                    "p.first_name as p_first_name",
                    "p.last_name as p_last_name",
                    "tp.id as treatment_plan_id",
                )
                ->orderByDesc("t.created_at")
                ->paginate(20);
            $data = [
                "tasks" => $tasks,
            ];
        }
        return view("users.view_tasks", $data);
    }
    public function finished_tasks(Request $request)//complete tasks
    {
        $data = [];
        $taskId = @$request->get('task');
        $notificationId = @$request->get('notify');
        if (Auth::user()->role == 'staff' || Auth::user()->role == 'lab' || Auth::user()->role == 'doctor') {
            $whereClauses = [
                ['t.status', 'completed'],
                ['t.type', Auth::user()->role],
            ];
            if (Auth::user()->role == 'doctor' || Auth::user()->role == 'lab') {
                array_push($whereClauses, ['t.user_id', Auth::user()->id]);
            }
            if (!empty($taskId) && !empty($notificationId)) {
                array_push($whereClauses, ["t.id", $taskId]);
                if (DB::table('notifications')->where('task_id', $taskId)->where('user_id', Auth::user()->id)->where('id', $notificationId)->whereNull('read_at')->exists()) {
                    DB::table('notifications')->where('id', $notificationId)->update([
                        "read_at" => date("Y-m-d H:i:s"),
                    ]);
                }
            }
            $tasks = DB::table('tasks as t')
                ->where($whereClauses)
                ->Join("p_treatment_plans as tp", function ($join) {
                    $join->on("t.treatment_plan_id", "=", "tp.id")
                        ->where('tp.is_deleted', 0);
                })
                ->Join("patients as p", function ($join) {
                    $join->on("p.id", "=", "tp.patient_id")
                        ->where('p.is_deleted', 0);
                })
                ->Join("users as u", function ($join) {
                    $join->on("u.id", "=", "p.user_id");
                })
                ->select(
                    "t.*",
                    "u.first_name",
                    "u.last_name",
                    "tp.phase",
                    "tp.previous_case_holder",
                    "p.pricing_package",
                    "p.first_name as p_first_name",
                    "p.last_name as p_last_name",
                )
                ->orderByDesc("t.created_at")
                ->paginate(20);
            $data = [
                "tasks" => $tasks,
            ];
        }
        return view("users.view_finished_tasks", $data);
    }
    public function in_progress(Request $request)
    {
        $data = [];
        $taskId = @$request->get('task');
        $notificationId = @$request->get('notify');
        if (Auth::user()->role == 'staff' || Auth::user()->role == 'lab' || Auth::user()->role == 'doctor') {
            $whereClauses = [
                ['t.is_submitted', 1],
                ['t.type', Auth::user()->role],
            ];
            if (Auth::user()->role == 'doctor' || Auth::user()->role == 'lab') {
                array_push($whereClauses, ['t.user_id', Auth::user()->id]);
            }
            if (!empty($taskId) && !empty($notificationId)) {
                array_push($whereClauses, ["t.id", $taskId]);
                if (DB::table('notifications')->where('task_id', $taskId)->where('user_id', Auth::user()->id)->where('id', $notificationId)->whereNull('read_at')->exists()) {
                    DB::table('notifications')->where('id', $notificationId)->update([
                        "read_at" => date("Y-m-d H:i:s"),
                    ]);
                }
            }
            $tasks = DB::table('tasks as t')
            ->whereNull('tp.tracking_id')
                ->where($whereClauses)
                ->Join("p_treatment_plans as tp", function ($join) {
                    $join->on("t.treatment_plan_id", "=", "tp.id")
                        ->where('tp.is_deleted', 0);
                })
                ->Join("patients as p", function ($join) {
                    $join->on("p.id", "=", "tp.patient_id")
                        ->where('p.is_deleted', 0);
                })
                ->Join("users as u", function ($join) {
                    $join->on("u.id", "=", "p.user_id");
                })
                ->select(
                    "t.*",
                    "u.first_name",
                    "u.last_name",
                    "tp.phase",
                    "tp.previous_case_holder",
                    "p.pricing_package",
                    "p.first_name as p_first_name",
                    "p.last_name as p_last_name",
                )
                ->orderByDesc("t.created_at")
                ->paginate(20);
            $data = [
                "tasks" => $tasks,
            ];
        }
        return view("users.view_in_progress_tasks", $data);
    }
    public function orders(Request $request)//new patient orders
    {
        $data = [];
        $taskId = @$request->get('task');
        $notificationId = @$request->get('notify');
        if (Auth::user()->role == 'staff' || Auth::user()->role == 'lab' || Auth::user()->role == 'doctor') {
            $whereClauses = [
                ['t.status', '!=', 'completed'],
                ['t.type', Auth::user()->role],
                ['tp.is_submitted', 1],
                ['tp.status', 'In Progress'],
                ['tp.case_holder', 'staff'],
            ];
            if (Auth::user()->role == 'doctor' || Auth::user()->role == 'lab') {
                array_push($whereClauses, ['t.user_id', Auth::user()->id]);
            }
            if (!empty($taskId) && !empty($notificationId)) {
                array_push($whereClauses, ["t.id", $taskId]);
                if (DB::table('notifications')->where('task_id', $taskId)->where('user_id', Auth::user()->id)->where('id', $notificationId)->whereNull('read_at')->exists()) {
                    DB::table('notifications')->where('id', $notificationId)->update([
                        "read_at" => date("Y-m-d H:i:s"),
                    ]);
                }
            }
            $tasks = DB::table('tasks as t')
                ->where($whereClauses)
                ->Join("p_treatment_plans as tp", function ($join) {
                    $join->on("t.treatment_plan_id", "=", "tp.id")
                        ->where('tp.is_deleted', 0);
                })
                ->Join("patients as p", function ($join) {
                    $join->on("p.id", "=", "tp.patient_id")
                        ->where('p.is_deleted', 0);
                })
                ->Join("users as u", function ($join) {
                    $join->on("u.id", "=", "p.user_id");
                })
                ->select(
                    "t.*",
                    "u.first_name",
                    "u.last_name",
                    "tp.phase",
                    "tp.previous_case_holder",
                    "p.pricing_package",
                    "p.first_name as p_first_name",
                    "p.last_name as p_last_name",
                )
                ->orderByDesc("t.created_at")
                ->paginate(20);
            $data = [
                "tasks" => $tasks,
            ];
        }
        return view("users.view_order_tasks", $data);
    }
    public function delivered(Request $request)//approved and added tracking no
    {
        $data = [];
        $taskId = @$request->get('task');
        $notificationId = @$request->get('notify');
        if (Auth::user()->role == 'staff' || Auth::user()->role == 'lab' || Auth::user()->role == 'doctor') {
            $whereClauses = [
                ['t.status', '!=', 'completed'],
                ['t.type', Auth::user()->role],
                ['t.task', 'Download Setup Files'],
            ];
            if (Auth::user()->role == 'doctor' || Auth::user()->role == 'lab') {
                array_push($whereClauses, ['t.user_id', Auth::user()->id]);
            }
            if (!empty($taskId) && !empty($notificationId)) {
                array_push($whereClauses, ["t.id", $taskId]);
                if (DB::table('notifications')->where('task_id', $taskId)->where('user_id', Auth::user()->id)->where('id', $notificationId)->whereNull('read_at')->exists()) {
                    DB::table('notifications')->where('id', $notificationId)->update([
                        "read_at" => date("Y-m-d H:i:s"),
                    ]);
                }
            }
            $tasks = DB::table('tasks as t')
                ->where($whereClauses)
                ->Join("p_treatment_plans as tp", function ($join) {
                    $join->on("t.treatment_plan_id", "=", "tp.id")
                        ->where('tp.is_deleted', 0);
                })
                ->Join("patients as p", function ($join) {
                    $join->on("p.id", "=", "tp.patient_id")
                        ->where('p.is_deleted', 0);
                })
                ->Join("users as u", function ($join) {
                    $join->on("u.id", "=", "p.user_id");
                })
                ->select(
                    "t.*",
                    "u.first_name",
                    "u.last_name",
                    "tp.phase",
                    "tp.previous_case_holder",
                    "p.pricing_package",
                    "p.first_name as p_first_name",
                    "p.last_name as p_last_name",
                )
                ->orderByDesc("t.created_at")
                ->paginate(20);
            $data = [
                "tasks" => $tasks,
            ];
        }
        return view("users.view_delivered_tasks", $data);
    }
}
