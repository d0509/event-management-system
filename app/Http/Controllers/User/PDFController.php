<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\TicketMail as MailTicketMail;
use App\Models\Booking;
use App\Notifications\TicketMail;
use App\Services\BookingService;
use App\Services\PDFService;
use \PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;


class PDFController extends Controller
{

     protected $bookingService;
     protected $PDFservice;

     public function __construct(BookingService $bookingService, PDFService $PDFservice)
     {
          $this->bookingService = $bookingService;
          $this->PDFservice = $PDFservice;
     }

     public function generatePDF(String $id)
     {
          $file = Booking::where('id',$id)->first(['pdf_name']);
          // dd($file['pdf_name']);
          // if($file['pdf_name'] == null){
              return redirect()->back()->with('message', 'Sorry! There are some issues downloading pdf');
              
          // } else {
               $filename = $file['pdf_name'];
               $pdf_location = public_path().'/storage/tickets/';
              $headers = array('Content-Type: application/pdf',);
              return Response::download($pdf_location.$filename,"$filename",$headers);
          // }
          

         
     }
}
