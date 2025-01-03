<?php

namespace App\Http\Controllers\Admin;

use App\Services\AuthService;
use App\Http\Requests\Auth\Login;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login()
    {
        return view('backend.pages.auth.login');
    }

    public function signIn(Login $request)
    {
        $this->authService->signIn($request);
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
