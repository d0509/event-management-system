<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        //
    }

   public function create()
    {
        if(Auth::user()){
            return view('User.pages.bookEvent');
        } else {
            session()->flash('danger', 'Please login to book !');
        }
    }

    public function store(Event $event)
    {
        $mytime = Carbon::now()->format('ymd');
        
        $last_booking = Booking::latest()->first() ;$booking_number = $mytime . sprintf('%03s', ((isset($last_booking) ? intval(substr($last_booking, 6)) : 0) + 1));

        $booking = Booking::create([
            'user_id' => Auth::user()->id, 
            'event_id' => $event->id,
            'booking_number' => $booking_number,
            'total' => $event->ticket,
        ]);

        // dd($booking->toArray());
        if($booking){
            session()->flash('success','Your ticket is booked successfully');
            return redirect()->route('homepage');
        } else {
            session()->flash('danger','There are some issues in booking tickts');
        }

    
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
