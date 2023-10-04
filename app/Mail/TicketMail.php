<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data, $pdf, $pdf_name;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $pdf, $pdf_name)
    {
        $this->subject = 'Your ticket has been booked successfully!';
        $this->with([
            'data' => $data,
            'pdf' => $pdf,
            'pdf_name' => $pdf_name,
        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        dd($this->data);
        return new Envelope(
            subject: 'Ticket booked successfully',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content($notifiable)
    {

        $mailTicket =  $notifiable->MailTicket;
        // return new Content(
        //     view: 'vendor.mail.html.layout',
        //     with: [
        //         'data' => $this->data,
        //         'pdf' => $this->pdf,
        //         'pdf_name' => $this->pdf_name
        //     ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
