<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    protected $bookingservice;

    public function __construct(BookingService $bookingservice)
    {
        $this->bookingservice = $bookingservice;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user_bookings =  $this->bookingservice->Companycollection($request);
            return $user_bookings;
        }
        return view('company.pages.booking');
    }

    // public function index(Request $request)
    // { 
    //     if ($request->ajax()) {
    //         $user_bookings =  $this->bookingservice->collection($request);
    //         return $user_bookings;
    //     }
    //     return view('User.pages.history');
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
