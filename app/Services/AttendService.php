<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AttendService{
    public function collection(){
        $data = Booking::select(['id', 'user_id', 'event_id','quantity', 'booking_number', 'no_of_attendees'])
            ->where('company_id', Auth::user()->company->id);

        return DataTables::of($data)
            ->orderColumn('user_id', function ($query, $order) {
                $query->orderBy('id', $order);
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