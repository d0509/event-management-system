<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Event;
use App\Models\User;
use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index(Request $request)
    {
        if (Auth::user()->role->name == config('site.role_names.admin')) {
            $companyCount = User::where('role_id', '=', 2)->count();
            $userCount = User::where('role_id', '=', 3)->count();
            $totalEvent =  Event::count();
            // $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
            //     ->whereYear('created_at', date('Y'))
            //     ->groupBy(DB::raw("Month(created_at)"))
            //     ->pluck('count', 'month_name');

            $users = User::select('role_id')
                ->where('role_id', '<>', '1')
                ->selectRaw('count(*) as count')
                ->selectRaw("Month(created_at) as month")
                ->groupBy('role_id', 'month')
                ->orderBy('month')
                ->get();

            $data = [];

            // Define the range of months (1 to 12)
            $allMonths = range(1, 12);

            // Loop through each user's data and update the $data array
            foreach ($users as $user) {
                if (!isset($data[$user->role_id])) {
                    $data[$user->role_id] = array_fill_keys($allMonths, 0);
                }
                $data[$user->role_id][$user->month] = $user->count;
            }

            // company engagement

            // $currentYear = Carbon::now()->year; // Get the current year

            // $allDaysInYear = [];
            // $startDate = Carbon::create($currentYear, 1, 1);
            // $endDate = Carbon::create($currentYear, 12, 31);

            // while ($startDate <= $endDate) {
            //     $allDaysInYear[] = $startDate->toDateString();
            //     $startDate->addDay();
            // }

            // $result = [];

            // $dayWiseBookings = Booking::select('companies.name as company_name', \DB::raw('DATE(bookings.created_at) as booking_day'), \DB::raw('SUM(bookings.quantity) as total_quantity'))
            //     ->join('companies', 'companies.id', '=', 'bookings.company_id')
            //     ->whereYear('bookings.created_at', $currentYear)
            //     ->groupBy('company_name', 'booking_day')
            //     ->get();

            // $bookingsData = [];
            // foreach ($dayWiseBookings as $booking) {
            //     $bookingsData[$booking->company_name][$booking->booking_day] = (int) $booking->total_quantity;
            // }

            // // Merge the database results with the full year list, filling in missing days with 0

            // foreach ($allDaysInYear as $day) {
            //     $result[$day] = [];
            //     foreach ($bookingsData as $company => $bookings) {
            //         $result[$day][$company] = $bookings[$day] ?? 0;
            //     }
            // }

            

            $companyData = Booking::select('companies.name as company_name', DB::raw('DATE(bookings.created_at) as booking_day'), DB::raw('SUM(bookings.quantity) as total_quantity'))
                ->join('companies', 'companies.id', '=', 'bookings.company_id')
                ->groupBy('company_name', 'booking_day')
                ->get();


            // dd($companyData->toArray());


            return view('backend.pages.dashboard', compact('companyCount', 'userCount', 'totalEvent', 'data', 'companyData'));
        } else {

            $company_id = Auth::user()->company->id;
            $totalEvent =  Event::where('company_id', '=', $company_id)->count();
            $todayEvent =  Event::where('company_id', '=', $company_id)->where('event_date', '=', Carbon::now())->count();
            $pastEvent = Event::where('company_id', '=', $company_id)->where('event_date', '<', Carbon::now())->count();
            $upcomingEvent = Event::where('company_id', '=', $company_id)->where('event_date', '>', Carbon::now())->count();

            return view('backend.pages.dashboard',compact('totalEvent', 'todayEvent', 'pastEvent', 'upcomingEvent'));
        }
    }
}
