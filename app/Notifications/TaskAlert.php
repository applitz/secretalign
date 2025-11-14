<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class TaskAlert extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $pk, $comment,$attachments;
    public function __construct($pk, $comment='',$attachments=[])
    {
        $this->pk = $pk;
        $this->comment = $comment;
        $this->attachments=$attachments;
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
        ->greeting("Hi, a new task has been added to you.")
        ->line($this->comment != null && $this->comment != '' ? $this->comment : '')
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
