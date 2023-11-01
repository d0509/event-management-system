<?php

namespace App\Services;

use App\Jobs\GenerateBookingTicket;
use App\Models\Booking;
use App\Models\CouponCode;
use App\Models\Event;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class BookingService
{
    public function collection()
    {
        $data = Booking::select(['id', 'event_id', 'booking_number', 'is_attended', 'is_free_event', 'quantity', 'ticket_price', 'sub_total', 'discount', 'total', 'type'])->where('user_id', '=', Auth::id())->with(['user', 'event'])->latest();
        return Datatables::of($data)
            ->addColumn('action', function ($row) {
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
            ->make(true);

        return true;
    }

    public function CompanyCollection(Request $request)
    {
        $data = Booking::select(['bookings.*'])
            ->with(['user', 'event'])
            ->where('company_id', Auth::user()->company->id)->latest();

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
            ->make(true);

        return true;
    }

    public function store($event, $inputs)
    {
        $quantity = $inputs['quantity'];
        $couponUsableCount = null;
        $coupon = null;
        $couponCodeId = null ;
        $discount = null;
        if ($inputs['code'] != null ) {
            $couponCode = $inputs['code'];
            $coupon = CouponCode::where('company_id', $event->company->id)->where('name', $couponCode)->first();
            $couponCodeId = CouponCode::where('company_id', $event->company->id)->where('name', $couponCode)->first()->id;
            $discount = CouponCode::where('company_id', $event->company->id)->where('name', $couponCode)->first()->percentage;
            $couponUsableCount = Booking::where('coupon_code_id',$couponCodeId)->where('user_id',Auth::id())->count();
        }

        $last_booking = Booking::latest()->first();
        $booking_number = Carbon::now()->format('ymd') . sprintf('%03s', ((isset($last_booking) ? intval(substr($last_booking, 6)) : 0) + 1));
        $totalSeats = Event::where('id', $event->id)->select('available_seat')->first();
        $bookedTickets = Booking::where('event_id', $event->id)->sum('quantity');
        $remainingSeats  = $totalSeats->available_seat - $bookedTickets;
        if ($coupon != null) {
            if($couponUsableCount >= $coupon->usable_count){
                session()->flash('danger','The coupon code has reached its maximum usage limit.');
            } 
        }
        if ($remainingSeats < $quantity) {
            session()->flash('danger', 'Sorry! Available seats are less than your requested seats');
        }         
        else {
            if(!$couponCodeId){
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
            } else {
                $booking = Booking::create([
                    'user_id' => Auth::id(),
                    'event_id' => $event->id,
                    'company_id' => $event->company_id,
                    'booking_number' => $booking_number,
                    'ticket_price' => $event->ticket,
                    'sub_total' => $event->ticket * $quantity,
                    'quantity' => $quantity,
                    'discount' => ( $event->ticket * $discount * $quantity) / 100,
                    'type' => $quantity > 1 ? 'multiple' : 'single',
                    'is_free_event' => $event->is_free,
                    'no_of_attendees' => 0,
                    'coupon_code_id' => $couponCodeId,
                    'total' => ($event->ticket * $quantity) -(( $event->ticket * $discount * $quantity) / 100),
                ]);
            }
            

            try {
                GenerateBookingTicket::dispatchSync($booking);
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

    public function verifyCouponCode($request)
    {
        $event = Event::where('id', $request->event)->first();
        $couponCode = CouponCode::where('name', $request->code)->where('company_id', $event->company_id)->first();
        $couponCodeId = CouponCode::where('name', $request->code)->where('company_id', $event->company_id)->first('id');
        $data = [];

        if (!$couponCode) {
            $data['error']['message'] = 'Coupon code not found';
        } elseif ($couponCode->is_active != 1) {
            $data['error']['message'] = 'Coupon code is currently not active';
        } elseif ($couponCode->usable_count < 1) {
            $data['error']['message'] = "You can't use this coupon code";
        } elseif ($couponCode->start_date > date('Y-m-d')) {
            $data['error']['message'] = "Invalid coupon code";
        } elseif ($couponCode->end_date < date('Y-m-d')) {
            $data['error']['message'] = "Invalid coupon code";
        } elseif ($event->company_id != $couponCode->company_id) {
            $data['error']['message'] = "You cannot use the given coupon code for booking this event";
        } else {
            $discountPercentage = $couponCode->percentage;
            $data['discountPercentage'] = $discountPercentage;
            $data['discountAmount'] = $event->ticket * ($discountPercentage / 100);
            $data['message'] = "Coupon code applied successfully.";
            $data['totalAmount'] = $event->ticket - $data['discountAmount'];
            $data['ticket'] = $event->ticket;
        }

        return $data;
    }
}
