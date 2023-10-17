<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\Create;
use App\Models\Booking;
use App\Models\Event;
use App\Services\BookingService;
use App\Services\PDFService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    protected $bookingService;
    protected $PDFservice;

    public function __construct(BookingService $bookingService, PDFService $PDFservice)
    {
        $this->bookingService = $bookingService;
        $this->PDFservice = $PDFservice;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user_bookings =  $this->bookingService->collection($request);
            return $user_bookings;
        }
        return view('frontend.pages.booking-history');
    }

    public function create()
    {
        if (Auth::user()) {
            return view('frontend.pages.book-event');
        } else {
            session()->flash('danger', 'Please login to book !');
        }
    }

    public function store(Event $event, Create $request)
    {
        $store_data = $this->bookingService->store($event, $request);
    //    dd($store_data->toArray());
    if($store_data){
        $this->PDFservice->generatePDF($store_data);
    }

        return redirect()->route('homepage');
    }

    public function show(string $id)
    {
        // dd($id);
        $booking = $this->bookingService->show($id);
        // dd($booking->booking_number);
        return view('frontend.pages.booking', [
            'booking' => $booking,
        ]);
    }    
}
