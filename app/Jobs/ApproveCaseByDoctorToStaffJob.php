<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\ApproveCaseByDoctorToStaff;
use Illuminate\Support\Facades\Notification;
class ApproveCaseByDoctorToStaffJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $staff, $details;
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
        // Send notification to staff
        foreach($this->staff as $staffMember){
            $email = $staffMember->email;
            Notification::route('mail', $email)
                    ->notify(new ApproveCaseByDoctorToStaff($staffMember, $this->details));
        }
    }
}
