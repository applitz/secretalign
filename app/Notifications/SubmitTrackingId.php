<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class SubmitTrackingId extends Notification
{
    use Queueable;
    public $details;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($details)
    {
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
            ->subject($this->details['subject'])
            ->markdown('emails.submit-tracking-id', [
                'doctor_name' => $this->details['doctor_name'],
                'patient_name' => $this->details['patient_name'],
                'title' => $this->details['title'],
                'tracking_id' => $this->details['tracking_id'],
                'comment' => $this->details['comment'],
            ]);

             // Handle attachments
            if (!empty($this->details['attachments'])) {
                $files = explode(',', $this->details['attachments']);

                foreach ($files as $file) {
                    $file = trim($file);

                    // adjust path as per your app (example assumes files stored in /storage/app/public/attachments/)
                    // $path = storage_path("app/public/attachments/{$file}");
                    $path = Storage::path('public/attachments/' . $file);
                    if (file_exists($path)) {
                        $mail->attach($path);
                    }
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
