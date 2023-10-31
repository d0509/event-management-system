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
}