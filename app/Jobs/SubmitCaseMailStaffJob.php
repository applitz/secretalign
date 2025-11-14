<?php

namespace App\Jobs;

use App\Notifications\SubmitAlertStaff;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SubmitCaseMailStaffJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $staff;
    public $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($staff, $details)
    {
        $this->staff = $staff;
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->staff as $staffMember){
            $email = $staffMember->email;
            Notification::route('mail', $email)
                    ->notify(new SubmitAlertStaff($staffMember, $this->details));
        }
    }
}
