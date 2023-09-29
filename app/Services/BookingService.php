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
            $data = Booking::select(['event_id', 'booking_number', 'is_attended', 'is_free_event', 'quantity', 'ticket_price', 'sub_total', 'discount', 'total', 'type'])->where('user_id', '=', Auth::id())->with(['user','event']);
            // dd($data);

            return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    // dd($row->event_id);
                    $editUrl = route('user.event.show', ['event' => $row->event_id]);
                    $btn = '<a href="' . $editUrl . '" class="text-white w-3 btn btn-primary mr-2"> <i class="fa-solid fa-eye"></i></a>';
                    // $btn .= '<a  href="#" class="text-white  btn btn-danger" onclick="event.preventDefault(); deleteCategory(' . $row->id . ');"> <i class="fa-sharp fa-solid fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('event_id',function($row){
                   return $row->event->name;
                })

                ->rawColumns(['action','event_id'])
                ->setRowId('id')
                ->addIndexColumn()
                // ->toJson()
                ->make(true);
        }
        return true;
    }

    public function Companycollection(Request $request)
    {
        // dd(Auth::user()->company->id); 
        $data = Booking::select(['user_id', 'event_id', 'booking_number', 'is_attended', 'is_free_event', 'quantity', 'ticket_price', 'sub_total', 'discount', 'total', 'type'])->with(['company','event'])->where('company_id',Auth::user()->company->id);
        
        return Datatables::of($data)
            ->addColumn('user_id',function($row){
                return $row->user->name;
            })
            ->addColumn('event_id',function($row){
                return $row->event->name; //event is name of the relation and name is the name of column in event table
            })
            ->setRowId('id')
            ->rawColumns(['user_id','event_id'])
            ->addIndexColumn()
            // ->toJson()
            ->make(true);

        return true;
    }
        
    public function store(Event $event, Create $request)
    {
        // dd($event->company_id);

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
                'company_id' =>$event->company_id,
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
