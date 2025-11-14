<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DoctorAlert extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $patient_email;
    public $patient_name;
    public function __construct($patient_email,$patient_name)
    {
        $this->patient_email = $patient_email;
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
    return (new MailMessage)
        ->subject("'$this->patient_name' - Treatment Plan 3D Viewer Link Sent")
        ->greeting("Dear Doctor,")
        ->line("The 3D viewer link for your patient, '$this->patient_name', has been successfully sent to their email address, '.$this->patient_email.'")
        ->action('View File', $this->patient_email)
        ->line('Sincerely,')
        ->line('Your SECRET Aligners Team');
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
