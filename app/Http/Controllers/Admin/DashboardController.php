<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login;
use App\Models\Company;
use App\Models\Event;
use App\Models\RoleUser;
use App\Models\User;
use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $authservice;

    public function __construct(AuthService $authservice)
    {
        $this->authservice = $authservice;
    }

    public function index(Request $request)
    {
        if (Auth::user()->role->firstWhere('name', config('site.roles.admin'))) {
            $companyCount = RoleUser::where('role_id','=',2)->count();
            $userCount = RoleUser::where('role_id','=',3)->count();
            $totalEvent =  Event::count();

            return view('admin.pages.contentdashboard',[

                'companyCount' => $companyCount,
                'userCount' => $userCount,
                'totalEvent' => $totalEvent,
            ]);
        } else {

            $company_id = Auth::user()->company->id;
            $totalEvent =  Event::where('company_id','=',$company_id)->count();
            $todayEvent =  Event::where('company_id','=',$company_id)->where('event_date','=',Carbon::now())->count();
            $pastEvent = Event::where('company_id','=',$company_id)->where('event_date','<',Carbon::now())->count();
            $upcomingEvent = Event::where('company_id','=',$company_id)->where('event_date','>',Carbon::now())->count();

            return view('admin.pages.contentdashboard',[
                
                    'totalEvent' =>$totalEvent,  
                    'todayEvent' => $todayEvent,
                    'pastEvent' => $pastEvent,
                    'upcomingEvent' =>$upcomingEvent,
            ]);
        }
    }

   
}
