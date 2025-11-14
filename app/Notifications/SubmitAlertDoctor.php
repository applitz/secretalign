<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmitAlertDoctor extends Notification
{
    use Queueable;
    public $doctor_name, $patient_name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($doctor_name=null,$patient_name=null)
    {
        $this->doctor_name = $doctor_name;
        $this->patient_name = $patient_name;
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
            ->subject("Thank you for placing order")
            ->markdown('emails.submit-case-doctor', [
                'doctor_name'     => $this->doctor_name,
                'patient_name' => $this->patient_name,
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
