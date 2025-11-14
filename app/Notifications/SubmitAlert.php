<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmitAlert extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($first_name=null,$last_name=null)
    {
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
        ->subject('Order Received - Review in Progress ')
        ->greeting("Dear Doctor,  ")
        ->line('Thank you for placing your order with Secret Clear Aligner System.')
        ->line('Patient Name: '.$this->first_name.' '.$this->last_name)
        ->line('Our team will now review your case requirements. We will contact you if any additional information is needed.')
        ->line('You can view your tasks and order status here: ')
        ->action('View Dashboard', 'https://secretalign-user.com/home')
        ->line('Thank you for choosing Secret Clear Aligner System!');

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
