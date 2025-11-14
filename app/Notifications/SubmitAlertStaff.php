<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmitAlertStaff extends Notification
{
    use Queueable;
    public $staff, $details;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($staff=null,$details=null)
    {
        $this->staff = $staff;
        $this->details = $details;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
         $mail = (new MailMessage)
            ->subject("Task Alert")
            ->markdown('emails.submit-case-staff', [
                'staff_name'     => $this->staff->first_name.' '.$this->staff->last_name,
                'doctor_name' => $this->details['doctor_name'],
                'patient_name' => $this->details['patient_name'],
            ]);
        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
