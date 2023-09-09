<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyRegistered extends Notification
{
    use Queueable;
    protected $request;

    /**
     * Create a new notification instance.
     */
    public function __construct($request)
    {
        $this->request = $request;
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

        ->line('The company has been added by the admin.')
        ->line('User Name: ' . $this->request->name)
        ->line('Company Name: ' . $this->request->company_name)
        ->line('Company Description:' . $this->request->description)
        ->line('Company Address: ' . $this->request->address)
        ->line('Company email: '.$this->request->email)
        ->line('Company contact no:' .$this->request->mobile_no)
        // ->line('Company Description' . $this->company->description)
        // // ->action('View Company', url('/companies/' . $this->company->id))
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
