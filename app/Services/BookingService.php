<?php

namespace App\Services;

use App\Http\Requests\Booking\Create;
use App\Models\Booking;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingService
{
    public function store(Event $event, Create $request)
    {

        $quantity = $request->quantity;
      

        $mytime = Carbon::now()->format('ymd');

        $last_booking = Booking::latest()->first();
        $booking_number = $mytime . sprintf('%03s', ((isset($last_booking) ? intval(substr($last_booking, 6)) : 0) + 1));

        $totalSeats = Event::where('id', '=', $event->id)->select('available_seat')->first();

        $bookedTickets = Booking::where('event_id', $event->id)->sum('quantity');

        $remainingSeats  = $totalSeats->available_seat - $bookedTickets;

        if ($remainingSeats < $quantity) {

            session()->flash('danger', 'Sorry! Available seats are less than your requested seats');

        } else {
            Booking::create([
                'user_id' => Auth::user()->id,
                'event_id' => $event->id,
                'booking_number' => $booking_number,
                'ticket_price' => $event->ticket,
                'sub_total' => $event->ticket * $quantity,
                'quantity' => $quantity,
                'discount' => 0,
                'total' => $event->ticket * $quantity,
                'type' => $quantity > 1 ? 'multiple' : 'single',
            ]);

            session()->flash('success', 'Your ticket is booked successfully');    
        }
    }
}
