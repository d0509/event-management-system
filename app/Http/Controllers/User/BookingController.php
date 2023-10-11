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

    protected $bookingservice;
    protected $PDFservice;

    public function __construct(BookingService $bookingservice, PDFService $PDFservice)
    {
        $this->bookingservice = $bookingservice;
        $this->PDFservice = $PDFservice;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user_bookings =  $this->bookingservice->collection($request);
            return $user_bookings;
        }
        return view('User.pages.history');
    }

    public function create()
    {
        if (Auth::user()) {
            return view('User.pages.bookEvent');
        } else {
            session()->flash('danger', 'Please login to book !');
        }
    }

    public function store(Event $event, Create $request)
    {
        $store_data = $this->bookingservice->store($event, $request);
        if ($store_data) {
            $this->PDFservice->generatePDF($store_data);
        }

        return redirect()->route('homepage');
    }

    public function show(string $id)
    {
        // dd($id);
        $booking = $this->bookingservice->show($id);
        // dd($booking->booking_number);
        return view('User.pages.booking', [
            'booking' => $booking,
        ]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
