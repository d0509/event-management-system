<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\Create;
use App\Http\Requests\CouponCode\Apply;
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
            $user_bookings =  $this->bookingService->collection($request);
            return $user_bookings;
        }
        return view('frontend.pages.booking-history');
    }

    public function create()
    {
        if (Auth::user()) {
            return view('frontend.pages.book-event');
        } else {
            session()->flash('danger', 'Please login to book !');
        }
    }

    public function store(Event $event, Create $request)
    {

        $this->bookingService->store($event, $request);
        return redirect()->back();
    }

    public function show(string $id)
    {
        $booking = $this->bookingService->show($id);
        
        return view('frontend.pages.booking', [
            'booking' => $booking,
        ]);
    } 
    
    public function verifyCouponCode(Apply $request){
      $response = $this->bookingService->verifyCouponCode($request);
       return response()->json($response);
    }
}