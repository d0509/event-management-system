<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class TicketMail extends Notification
{
    use Queueable;
    protected $data, $pdf, $pdfName;

    /**
     * Create a new notification instance.
     */
    public function __construct($data, $pdf, $pdfName)
    {
        $this->data = $data;
        $this->pdf = $pdf;
        $this->pdfName = $pdfName;
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
        // return (new MailMessage)->view(
        //     'emails.name', ['invoice' => $this->data]
        // );
        return (new MailMessage)
            ->line('I appreciate you booking your spot at the event. We are excited to share this event with you.We are grateful for your participation in our event.')
            ->line('Event Name: ' . $this->data->event->name)
            ->line('Event Date:' . Carbon::parse($this->data->event->event_date)->format(config('site.date_format')))
            // ->attachData($this->pdf, $this->pdfName, ['mime' => 'application/pdf',])
            ->line('Name: ' . $this->data->user->name)
            ->line('Event venue: ' . $this->data->event->venue)
            // ->line('To see location: '. $this->data->event->location)
            // ->action('See Location',url($this->data->event->location))
            ->action('See Ticket', url('storage/tickets/' . $this->pdfName))
            // ->action('Notification Action', url({{}}))
            ->line('Thank you for using our website!');
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
