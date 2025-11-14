<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class RejectAlert extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $comment,$attachments,$first_name,$last_name;
    public function __construct($comment,$first_name,$last_name)
    {
        $this->comment = $comment;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
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
        ->subject('Case Update: Treatment Not Recommended for'.$this->first_name.' '.$this->last_name)
        ->greeting("Dear Doctor,  ")
        ->line('Our thorough review process sometimes indicates that the optimal approach for a patients well-being is to not move forward with the aligner treatment. ')
        ->line('You will find a detailed explanation of this recommendation within the case review section of your Dashboard:')
        ->action('View Dashboard', 'https://secretalign-user.com/home')
        ->line($this->comment != null && $this->comment != '' ? $this->comment : '')
        ->line('We appreciate your careful consideration and dedication to patient care. ');

        // Check if attachment is provided and exists

    
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
