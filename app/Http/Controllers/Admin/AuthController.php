<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authservice;

    Public function __construct(AuthService $authservice)
    {
        $this->authservice = $authservice;
        
    }

    public function login()
    {
        return view('admin.auth.login');
    }

    public function signIn(Login $request){
        $this->authservice->signin($request);

        if ($request->user()->role->firstWhere('name', 'admin')) {
            return redirect()->route('adminDashboard');
        } else if($request->user()->role->firstWhere('name', 'company')) {
            return redirect()->route('companyDashboard');
        }
    }


}
