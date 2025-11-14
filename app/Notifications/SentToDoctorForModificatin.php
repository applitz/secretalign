<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class SentToDoctorForModificatin extends Notification
{
    use Queueable;
    public $subject;
    public $doctor_name;
    public $patient_name;
    public $comment;
    public $attachments;
    public $email;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $details)
    {
        Log::info('✅ Queue is working! Job executed with details: ', $details);

        $this->subject      = $details['subject'];
        $this->doctor_name  = $details['doctor_name'];
        $this->patient_name = $details['patient_name'];
        $this->comment      = $details['comment'];
        $this->attachments  = $details['attachments'];
        $this->email        = $details['email'];
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
            ->subject($this->subject )
            ->markdown('emails.sent-to-doctor-for-modificatin', [
                'doctor_name'     => $this->doctor_name,
                'patient_name' => $this->patient_name,
                'title' => $this->subject,
                'comment' => $this->comment,
            ]);

             // Handle attachments
            if (!empty($this->attachments)) {
                $files = explode(',', $this->attachments);

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
