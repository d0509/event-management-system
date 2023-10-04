<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactUsNotification extends Notification
{
    use Queueable;
    protected $contact_us;

    /**
     * Create a new notification instance.
     */
    public function __construct($contact_us)
    {
        $this->contact_us = $contact_us;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            // ->line('Hello Admin!')
            ->line('I wanted to inform you that we have received a new inquiry from a customer. Please find the details below:')
            ->line('Customer Name: ' . $this->contact_us->name)
            ->line('Customer Name:  ' . $this->contact_us->email)
            ->line('Customer Contact no.: ' .$this->contact_us->phone)
            ->line('Inquiry Content: '. $this->contact_us->message )
            ->line('Please review this inquiry and take the necessary actions to address the customer needs and questions.')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
