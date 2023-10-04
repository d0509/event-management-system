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
        // dd('im inside generate pdf');
        // dd($data->toArray());
        $user = $data->user;
        // dd('user data');
        // dd($data->user->toArray());
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

        // dd($data2);
        $pdf_name = 'booking_' . now()->timestamp . '.pdf';
        $pdf = PDF::loadView('my-ticket', [$data2]);


        $path = public_path().'storage/tickets/';
        $pdf->save($path  . $pdf_name);
        return url($path.$pdf_name);
        
            
            
            Booking::where('booking_number', $data->booking_number)->update(['pdf_name' => $pdf_name]);
            // dd
            // try {
            //     $user->notify(new TicketMail($data, $pdf, $pdf_name));
            // } catch (Exception $e) {
            //     Log::info($e);
            // }
        }
        // return $pdf->download($pdf_name);
    // }
}
