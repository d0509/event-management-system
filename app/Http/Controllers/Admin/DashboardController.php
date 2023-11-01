<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use App\Services\DashboardService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
         $this->dashboardService = $dashboardService;
    }
    public function index(Request $request)
    {
        if (Auth::user()->role_id == config('site.roles.admin')) {
            $companyCount = User::where('role_id', 2)->count();
            $userCount = User::where('role_id', 3)->count();
            $totalEvent =  Event::count();

            $users = User::select('role_id')
                ->where('role_id', '<>', '1')
                ->selectRaw('count(*) as count')
                ->selectRaw("Month(created_at) as month")
                ->groupBy('role_id', 'month')
                ->orderBy('month')
                ->get();

            $data = [];

            $allMonths = range(1, 12);

            foreach($users as $user) {
                if (!isset($data[$user->role_id])) {
                    $data[$user->role_id] = array_fill_keys($allMonths, 0);
                }
                $data[$user->role_id][$user->month] = $user->count;
            }

            $topCompanies = Event::selectRaw('companies.name as company_name, count(*) as event_count')
                ->join('companies', 'events.company_id', '=', 'companies.id')
                ->groupBy('company_name')
                ->orderBy('event_count', 'desc')
                ->limit(10)
                ->get();
               
            return view('backend.pages.dashboard', compact('companyCount', 'userCount', 'totalEvent', 'data', 'topCompanies'));
        } else {

            $company_id = Auth::user()->company->id;
            $totalEvent =  Event::where('company_id', '=', $company_id)->count();
            $todayEvent =  Event::where('company_id', '=', $company_id)->where('event_date', '=', Carbon::now()->toDateString())->count();
            $pastEvent = Event::where('company_id', '=', $company_id)->where('event_date', '<', Carbon::now()->toDateString())->count();
            $upcomingEvent = Event::where('company_id', '=', $company_id)->where('event_date', '>', Carbon::now()->toDateString())->count();
            $cityWiseEvents = Event::select('cities.name as city_name')
                ->selectRaw('count(*) as count')
                ->where('company_id', Auth::user()->company->id)
                ->join('cities', 'cities.id', '=', 'events.city_id')
                ->groupBy('city_name')
                ->get();

            return view('backend.pages.dashboard', compact('totalEvent', 'todayEvent', 'pastEvent', 'upcomingEvent', 'cityWiseEvents'));
        }
    }
}
