<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;


class TrackingAlert extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $comment,$button_label,$button_text,$attachments;
    public function __construct($comment='',$button_label,$button_text,$attachments = [],$first_name,$last_name)
    {
        $this->comment = $comment;
        $this->button_label = $button_label;
        $this->button_text = $button_text;
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
        ->subject('Good News: Your Secret Clear Aligners Are Shipping Soon')
        ->greeting("Dear Doctor, ")
        ->line('We are pleased to inform you that your patients aligners have completed production and are scheduled for shipment shortly. You can track the shipping status and estimated delivery timeframe here: ')
        // ->action($this->button_label, $this->button_text)
        ->line($this->comment != null && $this->comment != '' ? $this->comment : '')
        ->line("For patient: ".$this->first_name." ".$this->last_name)
        ->action($this->button_label, $this->button_text)
        ->line('Thank you for using Secret Clear Aligner System!');

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
