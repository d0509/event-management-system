<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\Create;
use App\Models\Booking;
use App\Models\Event;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    protected $bookingservice;

    public function __construct(BookingService $bookingservice)
    {
        $this->bookingservice = $bookingservice;
    }

    public function index()
    {
        //
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
        $this->bookingservice->store($event, $request);
        session()->flash('success', 'Your ticket is booked successfully');        
        return redirect()->route('homepage');
    }

    public function show(string $id)
    {
        //
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
