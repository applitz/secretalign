<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class SendToDoctorFromStaffForApproval extends Notification
{
    use Queueable;
    public $details;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $details)
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
            ->markdown('emails.sent-to-doctor-for-approval', [
                'doctor_name'     => $this->details['doctor_name'],
                'patient_name' => $this->details['patient_name'],
                'title' => $this->details['title'],
                'aligner_steps' => $this->details['aligner_steps'],
                'comment' => $this->details['comment'],
                'staff_name' => $this->details['staff_name'],
                'patient_link' => $this->details['patient_link'],
                'iframe_link' => $this->details['iframe_link'],
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
