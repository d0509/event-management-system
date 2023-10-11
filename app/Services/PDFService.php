<?php

namespace App\Services;

use \PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Booking;
use App\Notifications\TicketMail;

class PDFService
{
    public function generatePDF($data)
    {
        // dd($data['booking_number']);

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
        // $pdf = PDF::loadView('my-ticket', $data2);

        $pdf->save(public_path() . '/storage/tickets/' . $pdfName);
        // dd( Booking::where('booking_number', $data->booking_number)->get());
        Booking::where('booking_number', $data->booking_number)->update(['pdf_name' => $pdfName]);

        try {
            // $user->notify(new TicketMail($data, $pdf, $pdfName));
        } catch (Exception $e) {
            Log::info($e);
        }
    }

    function generateQrCodeAndLoadView( $data2,$view, $data)
    {
        // dd($data2);
        // $simple = \QrCode::size(120)->generate($data2);
        // dd($simple);
        $pdf = PDF::loadView($view, $data );
        return $pdf;
    }
}
