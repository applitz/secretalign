<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class ApproveAlert extends Notification
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
        ->greeting("Dear Doctor,  ")
        ->line('The treatment plan for your patient, '.$this->first_name.' is now ready for your review and approval. You can view your tasks and order status here:  ')
        ->line('Please review the plan at your convenience. If you have any modifications, please feel free to make them. Kindly provide a comment whenever you make any changes to the plan.')
        ->action('View Dashboard', 'https://secretalign-user.com/home')
        ->line('Added Comment: '.$this->comment != null && $this->comment != '' ? $this->comment : '')
        ->line('Best regards, SECRET Aligners Team')
        ->line('Thank you for choosing Secret Clear Aligner System!');

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
