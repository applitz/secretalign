<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PatientAlert extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $url;
    public $doctor_name;
    public function __construct($url,$doctor_name)
    {
       // dd($url,$doctor_name);
        $this->url = $url;
        $this->doctor_name = $doctor_name;
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
        ->subject("Review Your Aligners Treatment Plan")
        ->greeting("Dear Patient,")
        ->line("Please review your current treatment plan by clicking on the following link:")
        ->action('View File', $this->url)
        ->line("Please note that the 3D viewer may not perfectly reflect the actual progress of your treatment and the precise position of your teeth.")
        ->line("Sincerely,")
        ->line($this->doctor_name);
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
