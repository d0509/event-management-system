<?php

namespace App\Services;

use \PDF;
use Exception;
use Carbon\Carbon;
use App\Models\Booking;
use App\Notifications\TicketMail as NotificationsTicketMail;
use Illuminate\Support\Facades\Log;

class PDFService
{
    public function generatePDF($data)
    {
        $user = $data->user;

        $pdfData = [
            'owner_name' => $data->user->name,
            'date' =>  Carbon::parse($data->event->event_date)->format(config('site.date_format')),
            'event_name' => $data->event->name,
            'title' => $data->booking_number,
            'ticket_number' => $data->booking_number,
            'total' => $data->total,
            'discount' => $data->discount,
            'quantity' => $data->quantity,
            'price_per_ticket' => $data->ticket_price,
            'sub_total' => $data->sub_total,
            'host_company' => $data->company->name,
        ];

        $pdf = $this->generateQrCodeAndLoadView($data, 'my-ticket', $pdfData);


        $pdfName = 'booking_' . now()->timestamp . '.pdf';
        // $pdf = PDF::loadView('my-ticket', $data2);

        Booking::where('booking_number', $data->booking_number)->update(['pdf_name' => $pdfName]);

        try {
            $user->notify(new NotificationsTicketMail($data, $pdf, $pdfName));
        } catch (Exception $e) {
            Log::info($e);
        }
    }

    function generateQrCodeAndLoadView($data2, $view, $data)
    {
        // $simple = \QrCode::size(120)->generate($data2);
        $pdf = PDF::loadView($view, $data);
        dd($pdf);
        return $pdf;
    }
}
