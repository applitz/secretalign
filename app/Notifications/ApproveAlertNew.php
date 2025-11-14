<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class ApproveAlertNew extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $comment,$attachments,$first_name,$last_name;
    public function __construct($comment, $attachments = [],$first_name,$last_name)
    {
        $this->comment = $comment;
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
            ->subject('Treatment Plan is ready for Review for '.$this->first_name.' '.$this->last_name)
            ->markdown('emails.treatment_plan', [
                'first_name'  => $this->first_name,
                'last_name'   => $this->last_name,
                'comment'     => $this->comment,
            ]);

        // Attachments
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
