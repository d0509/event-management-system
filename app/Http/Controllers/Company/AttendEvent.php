<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\AttendEvent as CompanyAttendEvent;
use App\Models\Booking;
use App\Models\Event;
use App\Services\AttendEventService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendEvent extends Controller
{

    protected $attendService;

    public function __construct(AttendEventService $attendService)
    {
        $this->attendService = $attendService;
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user_bookings =  $this->attendService->collection();
            return $user_bookings;
        }
        return view('backend.pages.attend-event.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $todayEvents  =  Event::where('company_id', Auth::user()->company->id)->where('event_date', Carbon::now()->format('Y-m-d'))->select('id', 'name')->get();
        return view('backend.pages.attend-event.create', ['todayEvents' => $todayEvents]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyAttendEvent $request)
    {
        // dd($request);
        $eventId  = $request->event_id;
        $bookingNumber  = $request->booking_number;
        $noOfAttendee = $request->no_of_attendee;

        // dd($noOfAttendee);
        $booking = Booking::where('booking_number', $bookingNumber)->first();
        // dd($booking->toArray());

        $bookingEventId  = $booking->event_id;
        $bookingAttendee = $booking->no_of_attendees;
        $bookingQuantity = $booking->quantity;
        $sum = $bookingAttendee  +  $noOfAttendee;
        // dd(config('site.is_attended.attended'));

        if ($bookingEventId != $eventId) {
            session()->flash('danger', 'Booking number or your selected event is incorrect');
            return redirect()->route('company.attend-event.create');
        } elseif ($sum > $bookingQuantity) {
            session()->flash('danger', 'Please enter valid attendees count');
            return redirect()->route('company.attend-event.create');
        } else {
            $update =  $booking->update([
                'is_attended' => config('site.is_attended.attended'),
                'no_of_attendees' => $sum,
            ]);
            if ($update == true) {
                session()->flash('success', 'You have successfully added event as attended');
                return redirect()->route('company.attend-event.create');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
