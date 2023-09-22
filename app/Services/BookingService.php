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


        Booking::create([
            'user_id' => Auth::user()->id,
            'event_id' => $event->id,
            'booking_number' => $booking_number,
            'ticket_price' => $event->ticket,
            'sub_total' => $event->ticket * $quantity,
            'discount' => 0,
            'total' => $event->ticket * $quantity,
            'type' => $quantity > 1 ? 'multiple' : 'single',
        ]);

        
    }
}
