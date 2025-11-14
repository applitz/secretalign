<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;


class CustomAlert extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $comment, $subject,$attachments;
    public function __construct($comment='', $subject,$attachments = [],$first_name=null,$last_name=null)
    {
        $this->comment = $comment;
        $this->subject = $subject;
        $this->attachments = $attachments;
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
        ->subject($this->subject)
        ->greeting("Hi, a new task has been added to you.")
        ->line($this->comment != null && $this->comment != '' ? $this->comment : '')
        ->line("For patient: ".$this->first_name." ".$this->last_name)
        ->action('View Tasks', url('/home'))
        ->line('Thank you for using Secret Clear Aligner System');

        // Check if attachment is provided and exists
        if (!empty($this->attachments)) {
            $attachmentPath = Storage::path('public/attachments/' . $this->attachments);
            if (file_exists($attachmentPath) && is_file($attachmentPath)) {
                $mail->attach($attachmentPath);
            }
        }

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
