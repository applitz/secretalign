<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Services\TaskService;
use App\Jobs\ContinueTreatmentJob;
use App\Jobs\SubmitCaseMailJob;
use App\Jobs\SubmitCaseMailStaffJob;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;
use Illuminate\Support\Facades\Hash;
//use Auth;

class CasePhaseController extends Controller
{
    public $hashids;
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->hashids = new Hashids();
        View::share('hashids', $this->hashids);
    }

    public function cancel_requested_plan(Request $request)
    {
        $this->validate($request, [
            "treatment_plan_id" => "required",
            "password" => "required",
        ]);
        $user = DB::table('users')->where('role', 'superadmin')->where('id', Auth::user()->id)->first();
        if($user) {
            if(Hash::check($request->input('password'), $user->password)) {
                $treatment_plan = DB::table('p_treatment_plans')->where('id', $request->input('treatment_plan_id'))->first();
                if(!DB::table('p_treatment_plans')->where('patient_id', $treatment_plan->patient_id)->where('phase', '>', $treatment_plan->phase)->exists() && $treatment_plan->phase > 1) {
                    DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->delete();
                    return redirect('superadmin/patients')->with('success', 'Patient case cancelled');
                }
            }
            return redirect()->back()->with('error', 'Cannot match password');
        }
        dd();
        return redirect()->back()->with('error', 'You cannnot cancel this case');
    }

    public function request_new_plan(Request $request)
    {
        $comment = 'Aligners lost Track at Number '.$request->post('comment');
        $previous_plan = DB::table('p_treatment_plans')
            ->where('is_deleted', 0)
            ->where('patient_id', $request->input('patient_id'))
            ->orderByDesc('phase')
            ->first();

        $now = now();
        $planDue = @$previous_plan->treatment_plan_duration ? date("Y-m-d H:i:s", strtotime($previous_plan->treatment_plan_duration)) : null;

        if ( @$previous_plan->is_completed == 1 && ($planDue === null || $now <= $planDue) ) {
            // initiate new treatment
            $phase = DB::table('p_treatment_plans')->insertGetId([
                "patient_id" => $request->input('patient_id'),
                "phase" => $previous_plan->phase + 1,
                "lost_track_at_number" => $request->post('comment'),
                "is_editable" => 0,
                "status" => "Pending",
            ]);

            $order_id = DB::table('orders')->insertGetId([
                "user_id" => Auth::user()->id,
                "patient_id" => $request->input('patient_id'),
                "treatment_plan_id" => $phase,
                "datetime" => date("Y-m-d H:i:s"),
                "status" => 'pending'
            ]);

            $latest = DB::table('tasks')->insert([
                "treatment_plan_id" => $phase,
                "task" => 'Reopen an old case',
                "type" => 'staff',
                "user_id" => null,
                "status" => "completed",
                "created_at" => now()
            ]);

            $task = DB::table('tasks')
                ->where('treatment_plan_id', $phase)
                ->orderBy('id', 'desc')
                ->first();

            if ($comment) {
                DB::table('comments')->insert([
                    "treatment_plan_id" => $phase,
                    "task_id" => $task->id,
                    "added_by" => Auth::user()->id,
                    "from_role" => 'doctor',
                    "to_role" => 'staff',
                    "comment" => $comment,
                    "created_at" => now(),
                ]);
            }

             return response()->json(['success' => true, 'redirect_url' => url('patient/edit/' . $this->hashids->encode($phase))]);
        }

        // ❌ Return error response if case due date expired
        return response()->json([
            'success' => false,
            'message' => 'Case due date has expired. You cannot create a new plan.'
        ], 400);
    }

    public function duration_test()
    {
        // \Illuminate\Support\Facades\Notification::route('mail', ["ghulamali0424@gmail.com"])
        //     ->notify(new \App\Notifications\CustomAlert("Test", "test"));

        // $treatment_plans = DB::table('p_treatment_plans')->where('is_completed', 1)->get();
        // foreach ($treatment_plans as $plan) {
        //     $duration = $this->treatment_plan_duration($plan->completed_at, $plan->aligner_steps, $plan->phase);
        //     DB::table('p_treatment_plans')->where('id', $plan->id)->update([
        //         "treatment_plan_duration" => $duration,
        //     ]);
        // }
    }
    protected function treatment_plan_duration($timestamp, $steps, $phase)//depreciated
    {
        $additional_time = 12;
        if ($steps > 20) {
            $additional_time = 24;
        }
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

    public function continue_new_plan(Request $request)
    {
        if(Auth::user()->role != 'doctor'){
            abort(403, "Unauthorized Request | Can no longer request new cases");
        }
        if (DB::table('patients')
            ->where('id', $request->input('patient_id'))
            ->where('is_deleted', 0)->where('user_id', Auth::user()->id)
            ->whereNotNull('first_name')
            ->exists()
        ) {
            $treatment_plan = DB::table('p_treatment_plans')
                    ->where('is_deleted', 0)
                    ->where('patient_id', $request->input('patient_id'))
                    ->orderByDesc('phase')
                    ->first();
            // dd($treatment_plan);

            $treatment_plan = DB::table('p_treatment_plans as tp')
                                ->where('tp.patient_id', $request->input('patient_id'))
                                ->Join("patients as p", function ($join) {
                                    $join->on("tp.patient_id", "=", "p.id")
                                        ->where("p.is_deleted", 0);
                                })
                                ->orderByDesc('phase')
                                ->select("tp.*", "p.first_name", "p.last_name", "p.user_id", "p.pricing_package")
                                ->first();

            $comment = 'PLEASE SEND ME: '.$request->post('comment');
            $staff = DB::table('users')
                            ->where('role', 'staff')
                            ->get(['first_name', 'last_name', 'email'])
                            ->toArray();
            $details = [
                'subject' => 'Order Received - Review in Progress',
                'doctor_name' => Auth::user()->first_name." ".Auth::user()->last_name,
                'patient_name' => $treatment_plan->first_name." " . $treatment_plan->last_name,
                'email' => Auth::user()->email,
            ];

            SubmitCaseMailJob::dispatch($details);
            SubmitCaseMailStaffJob::dispatch($staff, $details);

            // $task = (new TaskService($treatment_plan->id));
            $latest = DB::table('tasks')->insert([
                "treatment_plan_id" => $treatment_plan->id,
                "task" => 'Continue an old case',
                "type" => 'staff',
                "user_id" => null,
                "status" => "pending",
                "created_at" => now()
            ]);
                //  dd($latest);
            $task_id= DB::table('tasks')->where('treatment_plan_id',$treatment_plan->id)->orderBy('id','desc')->first();

            if ($comment) {

                DB::table('comments')->insert([
                    "treatment_plan_id" => $treatment_plan->id,
                    "task_id" => $task_id->id,
                    "added_by" => Auth::user()->id,
                    "from_role" => 'doctor',
                    "to_role" => 'staff',
                    "comment" => $comment,
                    "created_at" => now(),
                ]);
            }

            $tasks = DB::table('tasks')
                ->where('treatment_plan_id', $treatment_plan->id)
                ->where('type','doctor')
                // ->where('status', '!=', 'completed')
                ->orderByDesc('id')
                ->get();
            // dd($tasks);
            foreach ($tasks as $task) {
                DB::table('tasks')->where('id', $task->id)->update([
                    "status" => 'completed',
                    "user_id" => Auth::id(),
                ]);
            }
            if ($task_id != null) {
                DB::table('p_treatment_plans')->where('id', $treatment_plan->id)->update([
                    "case_holder" => "staff",
                    "previous_case_holder" => "doctor",
                    "status" => "Waiting Staff Review",
                    "treatment_link" => $treatment_plan->treatment_link,
                    "is_completed" => 0,
                    "is_submitted" => 1,
                    "is_continue" => 1,
                    "tracking_id"=> null,
                    "is_treatment_submitted"=> 0,
                    "is_sent_to_lab"=> 1,

                ]);
            }

            // dd($request, $treatment_plan, $task, $task_id);
            return redirect('/patients')->with('success', 'Patient case continue');
        }
    }
}
