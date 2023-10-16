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

            // $companyWiseBookings = Booking::select('company_id', 'quantity')
            //     ->selectRaw('count(*) as count')
            //     ->selectRaw("Month(created_at) as month")
            //     ->groupBy('company_id', 'created_at', 'quantity')
            //     ->get();

            $companyWiseBookings = Booking::select('company_id', \DB::raw('SUM(quantity) as total_quantity'))
                ->groupBy('company_id')
                ->pluck('total_quantity', 'company_id')
                ->toArray();          


            // dd($companyWiseBookings);


            return view('admin.pages.content-dashboard', compact('companyCount', 'userCount', 'totalEvent', 'data','companyWiseBookings'));
        } else {

            $company_id = Auth::user()->company->id;
            $totalEvent =  Event::where('company_id', '=', $company_id)->count();
            $todayEvent =  Event::where('company_id', '=', $company_id)->where('event_date', '=', Carbon::now())->count();
            $pastEvent = Event::where('company_id', '=', $company_id)->where('event_date', '<', Carbon::now())->count();
            $upcomingEvent = Event::where('company_id', '=', $company_id)->where('event_date', '>', Carbon::now())->count();

            return view(
                'admin.pages.content-dashboard',
                compact('totalEvent', 'todayEvent', 'pastEvent', 'upcomingEvent')
            );
        }
    }
}
