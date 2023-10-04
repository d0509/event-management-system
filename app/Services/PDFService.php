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
        // dd($data->user->toArray());
        $user = $data->user;
        // dd($user->toArray());
        $data2 = [
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

        
        $pdfName = 'booking_' . now()->timestamp . '.pdf';
        $pdf = PDF::loadView('my-ticket', $data2);
        // dd($pdf->output());
       

        // $path = public_path() . '/storage/tickets/';
        // // dd($path);
        // $pdf->save($path  . $pdfName);
        if ($pdf->save(public_path() . '/storage/tickets/'.$pdfName)) {
            // dd("The PDF file has been saved successfully.");
        } else {
            // dd("The PDF file has not been saved successfully.");
        }

        if (file_exists(public_path() . '/storage/tickets/'.$pdfName)) {
        //    dd("The PDF file exists on disk.");
        } else {
            // dd("The PDF file does not exist on disk.");
        }       
        // dd( Booking::where('booking_number', $data->booking_number)->get());
        $update = Booking::where('booking_number', $data->booking_number)->update(['pdf_name' => $pdfName]);
        if($update == 1){
            // dd('pdf name entered in the database successfully'); 
        } else {
            // dd('there are some issue updating the name of the pdf');
        }
        try {
            $user->notify(new TicketMail($data, $pdf, $pdfName));
        } catch (Exception $e) {
            Log::info($e);
        }
        // return $pdf->download($pdfName);
    }
    // }
}
