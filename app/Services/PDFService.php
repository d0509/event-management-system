<?php

namespace App\Services;

use \PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;

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

        $pdf = $this->generateQrCodeAndLoadView($data,'my-ticket', $pdfData);
        $pdfName = 'booking_' . now()->timestamp . '.pdf';
        $pdf->save(public_path() . '/storage/tickets/' . $pdfName);
        Booking::where('booking_number', $data->booking_number)->update(['pdf_name' => $pdfName]);

        try {
            // $user->notify(new TicketMail($data, $pdf, $pdfName));
        } catch (Exception $e) {
            Log::info($e);
        }
    }

    function generateQrCodeAndLoadView( $data2,$view, $data)
    {
        $pdf = PDF::loadView($view, $data );
        return $pdf;
    }
}
