<?php

namespace App\Http\Controllers;

use App\Http\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;
use Exception;

class CronJobController extends Controller
{
    public function cancel_not_approved_cases()
    {
        $treatment_plans = DB::table('p_treatment_plans as tp')
            ->where('tp.is_completed', 0)
            ->where('tp.cancellation_date', date("Y-m-d"))
            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", "=", "p.id")
                    ->where("p.is_deleted", 0);
            })
            ->Join("users as u", function ($join) {
                $join->on("p.user_id", "=", "u.id");
            })
            ->select("tp.*", "p.user_id", "u.email as doctor_email")
            ->get();
        foreach ($treatment_plans as $plan) {
            $treatment_plan_id = $plan->id;
            $task = (new TaskService($treatment_plan_id));

            if ($plan->case_holder == 'staff') {
                $task->complete_task("staff");
            }
            if ($plan->case_holder == 'doctor') {
                $task->complete_task("doctor");
            }
            $task->liveAlert("Treatment plan is cancelled. The cancellation fees of €150 will be applied. The setup is not confirmed whithin 30 days after setup confirmation request notice.", $plan->user_id, "doctor");
            DB::table('p_treatment_plans')->where('id', $treatment_plan_id)->update([
                "is_cancelled" => 1,
                "case_holder" => "doctor",
                "status" => "Cancelled",
            ]);
            try {
                // \Illuminate\Support\Facades\Notification::route('mail', [$plan->doctor_email])
                //     ->notify(new \App\Notifications\CustomAlert("Treatment plan is cancelled. The cancellation fees of €150 will be applied. The setup is not confirmed whithin 30 days after setup confirmation request notice.", "Treatment plan is cancelled."));
            } catch (Exception $e) {
            }
        }
    }
    public function send_cancellation_notification()
    {

        $treatment_plans = DB::table('p_treatment_plans as tp')
            ->where('tp.is_completed', 0)
            ->where('tp.cancellation_date', '>', date("Y-m-d"))
            ->Join("patients as p", function ($join) {
                $join->on("tp.patient_id", "=", "p.id")
                    ->where("p.is_deleted", 0);
            })
            ->Join("users as u", function ($join) {
                $join->on("p.user_id", "=", "u.id");
            })
            ->select("tp.*", "p.user_id", "u.email as doctor_email")
            ->get();
        foreach ($treatment_plans as $plan) {
            $targetDate = new DateTime(date("Y-m-d", strtotime($plan->cancellation_date)));
            $twoWeeksBefore = $targetDate->sub(new DateInterval('P14D')); // subtract 2 weeks

            $today = new DateTime(date("Y-m-d")); // current date

            if ($today == $twoWeeksBefore) {
                try {
                    \Illuminate\Support\Facades\Notification::route('mail', [$plan->doctor_email])
                        ->notify(new \App\Notifications\CancellationAlert($plan->id));
                } catch (Exception $e) {
                }
            }
        }
    }
    public function syncTreatmentPlanDocument()
    {
        $job = DB::table('sync_queues')->where('is_synced', 0)->where('is_cancelled', 0)->first();
        if(@$job) {
            $treatment_plan = DB::table('p_treatment_plans as tp')
                            ->where('tp.is_deleted', 0)
                            ->where('tp.id', $job->treatment_plan_id)
                            ->Join("patients as p", function ($join) {
                                $join->on("tp.patient_id", '=', "p.id")
                                    ->where('p.is_deleted', 0);
                            })
                            ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package", "p.nemotech_patient_id")
                            ->first();
            if(@$treatment_plan) {
                $nemotech = new \App\Http\Services\NemoTechService($treatment_plan->first_name, $treatment_plan->last_name, $treatment_plan->dob, $treatment_plan->nemotech_patient_id);
                $nemotech->syncDocuments($treatment_plan, $job);
            }
            else {
                DB::table('sync_queues')->where('id', $job->id)->update([
                    "is_cancelled" => 1,
                ]);
            }
        }
        return response()->json([
            "status" => "ok",
        ]);
    }
}
