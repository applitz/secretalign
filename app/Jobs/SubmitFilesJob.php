<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SubmitFiles;
class SubmitFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $details, $staff;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($staff, $details)
    {
        $this->details = $details;
        $this->staff = $staff;
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
            Notification::route('mail', $email)->notify(new SubmitFiles($this->details, $staffMember));
        }
    }
}
