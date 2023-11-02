<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\Create;
use App\Http\Requests\CouponCode\Apply;
use App\Models\Booking;
use App\Models\Event;
use App\Services\BookingService;
use App\Services\PDFService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected $bookingService;
    protected $PDFservice;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
        $this->PDFservice = new PDFService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $userBookings =  $this->bookingService->collection($request);
            return $userBookings;
        }
        return view('frontend.pages.booking-history');
    }

    public function create()
    {
            return view('frontend.pages.book-event');
    }

    public function store(Event $event, Create $request)
    {

        $this->bookingService->store($event, $request);
        return redirect()->back();
    }

    public function show(Booking $booking)
    {
        return view('frontend.pages.booking', [
            'booking' => $booking,
        ]);
    } 
    
    public function verifyCouponCode(Apply $request){
      $response = $this->bookingService->verifyCouponCode($request);
       return response()->json($response);
    }
}