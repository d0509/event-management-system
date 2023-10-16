<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login;
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
        // if(Auth::user()->role_id ==  config('site.roles.admin'))
        if (Auth::user()->role->name == config('site.role_names.admin')) {
            $companyCount = User::where('role_id', '=', 2)->count();
            $userCount = User::where('role_id', '=', 3)->count();
            $totalEvent =  Event::count();
            // $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
            //     ->whereYear('created_at', date('Y'))
            //     ->groupBy(DB::raw("Month(created_at)"))
            //     ->pluck('count', 'month_name');

            $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
                ->whereYear('created_at', date('Y'))
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('count', 'month_name');
                
            $labels = $users->keys();
            $data = $users->values();

            return view('admin.pages.content-dashboard', [
                'companyCount' => $companyCount,
                'userCount' => $userCount,
                'totalEvent' => $totalEvent,
                'labels' => $labels,
                'data' => $data,
            ]);
        } else {

            $company_id = Auth::user()->company->id;
            $totalEvent =  Event::where('company_id', $company_id)->count();
            $todayEvent =  Event::where('company_id', $company_id)->where('event_date', '=', Carbon::now())->count();
            $pastEvent = Event::where('company_id', $company_id)->whereDate('event_date', Carbon::today())->count();
            $upcomingEvent = Event::where('company_id', $company_id)->where('event_date', '>', Carbon::now())->count();

            return view('admin.pages.content-dashboard', [
                'totalEvent' => $totalEvent,
                'todayEvent' => $todayEvent,
                'pastEvent' => $pastEvent,
                'upcomingEvent' => $upcomingEvent,
            ]);
        }
    }
}
