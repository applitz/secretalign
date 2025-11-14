<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Exception;

class TaskService
{
    public $treatment_plan_id;
    public function __construct($treatment_plan_id)
    {
        $this->treatment_plan_id = $treatment_plan_id;
    }
    public function liveAlert($body, $user_id, $type, $task_id = null)
    {
        $path = storage_path('al-secret-dev-firebase-adminsdk-fe376-23fb4976a1.json');
        $data = ['role' => $type,    'user' => $user_id,];
        if ($type == 'doctor' || $type == 'lab' || $type == 'superadmin' || $type == 'advisor') {
            $user = DB::table('users')->where('id', $user_id)->first();
            if (@$user) {
                DB::table('notifications')->insert([
                    "user_id" => $user->id,
                    "type" => $type,
                    "body" => $body,
                    "task_id" => $task_id,
                    "treatment_plan_id" => $this->treatment_plan_id,
                ]);
            }
        }
        if ($type == 'staff') {
            foreach (DB::table('users')->where('role', 'staff')->pluck('id')->toArray() as $u) {
                DB::table('notifications')->insert([
                    "type" => $type,
                    "body" => $body,
                    "task_id" => $task_id,
                    "user_id" => $u,
                    "treatment_plan_id" => $this->treatment_plan_id,
                ]);
            }
        }
    }
    public function sendMail($pk, $type, $user, $comment,$attachments)
    {
        try {
            $routes = [];
            if ($type == 'staff') {
                $routes = DB::table('users')->where('role', 'staff')->pluck("email")->toArray();
            }
            if ($type == 'doctor' || $type == 'lab') {
                $email = @DB::table('users')->where('role', $type)->where('id', $user)->first()->email;
                if ($email) {
                    array_push($routes, $email);
                }
            }

            \Illuminate\Support\Facades\Notification::route('mail', $routes)
                ->notify(new \App\Notifications\TaskAlert($pk, $comment,$attachments));
        } catch (Exception $e) {
        }
    }
    public function create_task($type, $task, $user_id = null, $comment = null, $from_role = null, $to_role = null,$attachments=null,$isMail=null)
    {
        if (!DB::table("tasks")->where("treatment_plan_id", $this->treatment_plan_id)->where("type", $type)->where("status", "pending")->exists()) {
            $latest = DB::table('tasks')->insertGetId([
                "treatment_plan_id" => $this->treatment_plan_id,
                "task" => $task,
                "type" => $type,
                "user_id" => $user_id,
                "status" => "pending",
            ]);

            if ($attachments != null || $comment != null) {
                DB::table('comments')->insert([
                    "treatment_plan_id" => $this->treatment_plan_id,
                    "task_id" => $latest,
                    "added_by" => Auth::user()->id,
                    "from_role" => $from_role,
                    "to_role" => $to_role,
                    "comment" => $comment,
                    'attachments'=>$attachments,
                    "created_at" => date(format: "Y-m-d H:i:s"),
                ]);
               // dd($comment);
            }
            // $this->liveAlert("You have a new task.", $user_id, $type, $latest);
            //     $this->sendMail($latest, $type, $user_id, $comment,$attachments);

                        return $latest;
        }
    }

    public function create_task_withoutMail($type, $task, $user_id = null, $comment = null, $from_role = null, $to_role = null,$attachments=null)
    {
        if (!DB::table("tasks")->where("treatment_plan_id", $this->treatment_plan_id)->where("type", $type)->where("status", "pending")->exists()) {
           //dd("true");
            $latest = DB::table('tasks')->insertGetId([
                "treatment_plan_id" => $this->treatment_plan_id,
                "task" => $task,
                "type" => $type,
                "user_id" => $user_id,
                "status" => "pending",
            ]);

            if ($attachments != null || $comment != null) {
                DB::table('comments')->insert([
                    "treatment_plan_id" => $this->treatment_plan_id,
                    "task_id" => $latest,
                    "added_by" => Auth::user()->id,
                    "from_role" => $from_role,
                    "to_role" => $to_role,
                    "comment" => $comment,
                    'attachments'=>$attachments,
                    "created_at" => date(format: "Y-m-d H:i:s"),
                ]);
               // dd($comment);
            }
            $this->liveAlert("You have a new task.", $user_id, $type, $latest);
                        return $latest;
        }
    }
    public function complete_task($type, $user_id = null)
    {
        $whereClauses = [
            ['type', $type],
        ];
        if ($user_id != null) {
            array_push($whereClauses, ['user_id', $user_id]);
        }
        $tasks = DB::table('tasks')
            ->where('treatment_plan_id', $this->treatment_plan_id)
            ->where($whereClauses)
            ->where('status', '!=', 'completed')
            ->orderByDesc('id')
            ->get();

        foreach ($tasks as $task) {
            DB::table('tasks')->where('id', $task->id)->update([
                "status" => 'completed',
            ]);
        }
    }
    public function get_task($type, $user_id = null)
    {
        $whereClauses = [
            ['type', $type],
        ];
        if ($user_id != null) {
            array_push($whereClauses, ['user_id', $user_id]);
        }
        $task = DB::table('tasks')
            ->where('treatment_plan_id', $this->treatment_plan_id)
            ->where($whereClauses)->where('status', '!=', 'completed')
            ->orderByDesc('id')
            ->first();
        $taskId = @$task->id ? $task->id : null;
        return $taskId;
    }
}
