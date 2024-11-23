<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingService;
use App\Services\PDFService;
use Illuminate\Support\Facades\Response;
class PDFController extends Controller
{

     protected $bookingService;
     protected $PDFservice;

     public function __construct(PDFService $PDFservice)
     {
          $this->bookingService = new BookingService();
          $this->PDFservice = $PDFservice;
     }

     public function generatePDF(String $id)
     {
          $file = Booking::where('id', $id)->select('pdf_name')->first();
          $fileName = $file['pdf_name'];

          $pdf_location = public_path() . '/storage/tickets/';
          $headers = array('Content-Type: application/pdf',);
          return Response::download($pdf_location . $fileName, "$fileName", $headers);
     }
}
