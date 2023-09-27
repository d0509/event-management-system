<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login;
use App\Models\Company;
use App\Models\Event;
use App\Models\RoleUser;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $authservice;

    public function __construct(AuthService $authservice)
    {
        // dd(4);
        $this->authservice = $authservice;
    }

    public function index()
    {
        dd(5);
    }

    public function getData(Request $request)
    {
        // dd(User::count());
       
            if (Auth::user()->role->firstWhere('name', config('site.roles.admin'))) {
                return view('admin.pages.contentdashboard',[
                    'companyCount' => RoleUser::where('role_id','=',2)->count(),
                    'userCount' => RoleUser::where('role_id','=',3)->count(),
                    'eventCount' => Event::count()
                ]);
            } elseif ($request->user()->role->firstWhere('name', config('site.roles.company'))) {
                return view('admin.pages.contentdashboard');
            }
       
    }
}
