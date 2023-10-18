<?php

namespace App\Services;

use \PDF;
use App\Http\Requests\Booking\Create;
use App\Jobs\GenerateBookingTicket;
use App\Models\Booking;
use App\Models\Event;
use App\Notifications\TicketMail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;

class BookingService
{

    public function collection()
    {

        

        $data = Booking::select(['id', 'event_id', 'booking_number', 'is_attended', 'is_free_event', 'quantity', 'ticket_price', 'sub_total', 'discount', 'total', 'type'])->where('user_id', '=', Auth::id())->with(['user', 'event']);
        // dd($data);

        return Datatables::of($data)
            ->addColumn('action', function ($row) {
                // dd($row->event_id);
                $ShowUrl = route('user.booking.show', ['booking' => $row->id]);
                $downloadUrl = route('download-ticket', ['booking' => $row->id]);
                $btn = '<div class="d-flex"><a href="' . $ShowUrl . '" class="text-white w-3 btn btn-primary mr-2"> <i class="fa-solid fa-eye"></i></a><a href="' . $downloadUrl . '" class="text-white w-3 btn btn-primary mr-2"> <i class="fas fa-download"></i></a></div>';
                
                return $btn;
            })
            ->orderColumn('event_id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->addColumn('event_id', function ($row) {
                return $row->event->name;
            })

            ->rawColumns(['action', 'event_id'])
            ->setRowId('id')
            ->addIndexColumn()
            // ->toJson()
            ->make(true);

        return true;
    }

    public function CompanyCollection(Request $request)
    {
        // dd(Auth::user()->company->id);
        $data = Booking::select(['bookings.*'])
            ->with(['user', 'event'])
            ->where('company_id', Auth::user()->company->id);

        return Datatables::of($data)
            ->orderColumn('user_id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->addColumn('user_id', function ($row) {
                return $row->user->name;
            })
            ->addColumn('event_id', function ($row) {
                return $row->event->name; //event is name of the relation and name is the name of column in event table
            })
            ->setRowId('id')
            ->rawColumns(['user_id', 'event_id'])
            ->addIndexColumn()
            // ->toJson()
            ->make(true);

        return true;
    }

    public function store($event, $inputs)
    {
        // dd($inputs);
        $quantity = $inputs['quantity'];

        $last_booking = Booking::latest()->first();
        $booking_number = Carbon::now()->format('ymd') . sprintf('%03s', ((isset($last_booking) ? intval(substr($last_booking, 6)) : 0) + 1));

        $totalSeats = Event::where('id', '=', $event->id)->select('available_seat')->first();

        $bookedTickets = Booking::where('event_id', $event->id)->sum('quantity');

        $remainingSeats  = $totalSeats->available_seat - $bookedTickets;

        if ($remainingSeats < $quantity) {

            session()->flash('danger', 'Sorry! Available seats are less than your requested seats');
        } else {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'event_id' => $event->id,
                'company_id' => $event->company_id,
                'booking_number' => $booking_number,
                'ticket_price' => $event->ticket,
                'sub_total' => $event->ticket * $quantity,
                'quantity' => $quantity,
                'discount' => 0,
                'total' => $event->ticket * $quantity,
                'type' => $quantity > 1 ? 'multiple' : 'single',
                'is_free_event' => $event->is_free,
                'no_of_attendees' => 0,
            ]);

            try {
                GenerateBookingTicket::dispatch($booking);
            } catch (Exception $e) {
                Log::info($e);
            }
        }
    }

    public function show(string $id)
    {
        $booking = Booking::where('id', $id)->first();
        return $booking;
    }
}
