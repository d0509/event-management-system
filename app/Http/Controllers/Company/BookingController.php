<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $userBookings =  $this->bookingService->CompanyCollection($request);
            return $userBookings;
        }
        return view('backend.pages.booking-history.index');
    }
}
