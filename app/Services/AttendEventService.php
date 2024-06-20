<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AttendEventService{
    public function collection(){
        $data = Booking::select('id', 'user_id', 'event_id','quantity', 'booking_number', 'no_of_attendees')
            ->where('company_id', Auth::user()->company->id)->latest();

        return DataTables::of($data)
            ->orderColumn('user_id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->addColumn('event_id',function($row){
                return $row->event->name;
            })
            ->addColumn('user_id', function ($row) {
                return $row->user->name;
            })
           
            ->setRowId('id')
            ->rawColumns(['user_id', 'event_id'])
            ->addIndexColumn()
            // ->toJson()
            ->make(true);

        return true;
    }

    public function attend($request){
        $eventId  = $request->event_id;
        $bookingNumber  = $request->booking_number;
        $noOfAttendee = $request->no_of_attendee;
        $booking = Booking::where('booking_number', $bookingNumber)->first();
        $bookingEventId  = $booking->event_id;
        $bookingAttendee = $booking->no_of_attendees;
        $bookingQuantity = $booking->quantity;
        $sum = $bookingAttendee  +  $noOfAttendee;
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
}