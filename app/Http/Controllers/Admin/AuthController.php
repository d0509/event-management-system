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
        $this->authservice->signIn($request);

        if (Auth::user()) {
            if ($request->user()->role->firstWhere('name', config('site.roles.admin'))) {
                return redirect()->route('admin.dashboard');
            } else if ($request->user()->role->firstWhere('name', config('site.roles.company'))) {
                return redirect()->route('company.dashboard');
            }
        } else {
            return redirect()->route('admin.login');
        }
    }
}
