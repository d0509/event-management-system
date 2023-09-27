<?php

namespace App\Services;

use App\Http\Requests\Booking\Create;
use App\Models\Booking;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BookingService
{

    public function collection(Request $request)
    {
        if ($request->ajax()) {
            // dd('hi');
            $data = Booking::select(['event_id', 'booking_number', 'is_attended', 'is_free_event', 'quantity', 'ticket_price', 'sub_total', 'discount', 'total', 'type'])->where('user_id', '=', Auth::id());
            // dd($data);

            return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    // dd($row);
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->setRowId('id')
                ->addIndexColumn()
                // ->toJson()
                ->make(true);
        }
        return true;
    }

    public function Companycollection(Request $request)
    {
        $data = Booking::select(['user_id', 'event_id', 'booking_number', 'is_attended', 'is_free_event', 'quantity', 'ticket_price', 'sub_total', 'discount', 'total', 'type']);
        
        return Datatables::of($data)
            ->setRowId('id')
            ->addIndexColumn()
            // ->toJson()
            ->make(true);

        return true;
    }
        
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
