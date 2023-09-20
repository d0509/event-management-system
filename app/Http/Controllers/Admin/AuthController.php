<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authservice;

    public function __construct(AuthService $authservice)
    {
        $this->authservice = $authservice;
    }

    public function login()
    {
        return view('admin.auth.login');
    }

    public function signIn(Login $request)
    {
        $this->authservice->signin($request);

        if (Auth::user()) {
            if ($request->user()->role->firstWhere('name', 'admin')) {
                return redirect()->route('adminDashboard');
            } else if ($request->user()->role->firstWhere('name', 'company')) {
                return redirect()->route('companyDashboard');
            }
        } else {
            return redirect()->route('admin.login');
        }
    }
}
