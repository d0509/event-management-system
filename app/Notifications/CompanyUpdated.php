<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyUpdated extends Notification
{
    use Queueable;
    protected $company;
    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($company,$user)
    {
        $this->company = $company;
        $this->user = $user;
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
            ->line('The company has been updated successfully.')
            ->line('Company Name: ' . $this->company->name)
            ->line('User Name: ' . $this->user->name)
            ->line('Company Registeration Status:' . $this->user->status)
            ->line('Company email: '.$this->user->email)
            ->line('Company contact no:' .$this->user->mobile_no)
            ->line('Company Description' . $this->company->description)
            ->line('Company Address: ' . $this->company->address)
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
