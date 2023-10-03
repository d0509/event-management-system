<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingService;
use \PDF;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class PDFController extends Controller
{

     protected $bookingService;

     public function __construct(BookingService $bookingService)
     {
          $this->bookingService = $bookingService;
     }

     public function generatePDF(String $id)
     {
          $data = $this->bookingService->show($id);
          //     dd($data->pdf_name == null); 
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

          if($data->pdf_name == null){
               $pdf_name = 'booking_' . now()->timestamp . '.pdf';
               $pdf = PDF::loadView('my-ticket', $data2);
               Storage::put('public/tickets/' . $pdf_name, $pdf->output());
               // session()->flash('success','PDF stored locally');
     
               Booking::where('booking_number', $data->booking_number)->update(['pdf_name' => $pdf_name]);

               
               
          }
          return redirect()->route('user.booking.index');

         
         
          // $pdf->download($pdf_name);

     }
}
