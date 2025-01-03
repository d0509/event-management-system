<?php

namespace App\Jobs;

use Exception;
use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use App\Notifications\TicketMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class GenerateBookingTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $booking;
    /**
     * Create a new job instance.
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pdfData = [
            'user_name' => $this->booking->user->name,
            'date' => Carbon::parse($this->booking->event->event_date)->format(config('site.date_format')),
            'event_name' => $this->booking->event->name,
            'booking_no' => $this->booking->booking_number,
            'start_time' => $this->booking->event->start_time,
            'quantity' => $this->booking->quantity,
            'qr_code' => base64_encode(QrCode::format('svg')->size(120)->errorCorrection('H')->generate($this->booking->booking_number)),
        ];

        $pdf = FacadePdf::loadView('pdf.booking-ticket', $pdfData);

        $pdfName = 'booking_' . now()->timestamp . '.pdf';
        $path = public_path('storage/tickets');
        if (!file_exists($path)) {
            mkdir($path, 0755, true); // Create directory with proper permissions
        }

        $pdf->save($path . '/' . $pdfName);

            Booking::where('booking_number', $this->booking->booking_number)->update(['pdf_name' => $pdfName]);
        try {
            $this->booking->user->notify(new TicketMail($this->booking, $pdf, $pdfName));
            session()->flash('success', 'Ticket Booked successfully');
        } catch (Exception $e) {
            Log::info($e);
        }
    }
}
