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

     public function downloadPDF(String $id)
     {          
          return $this->PDFservice->downloadPDF($id);         
     }
}
