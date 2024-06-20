<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\Register;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPassword;
use App\Http\Requests\Auth\ResetPassword;
use App\Services\AuthService;
use App\Services\CityService;
use App\Services\CompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    protected $authService;
    protected $cityService;
    protected $companyService;

    public function __construct(AuthService $authService)
    {
        $this->companyService = new CompanyService();
        $this->cityService = new  CityService();
        $this->authService = $authService;
    }

    public function login()
    {
        return view('frontend.auth.login');
    }

    public function signIn(Login $request): RedirectResponse
    {
        $this->authService->signIn($request);
        return redirect()->intended(route('home'));
    }

    public function register()
    {
        if (!Auth::user()) {
            $cities = $this->cityService->collection();
            return view('frontend.auth.register', [
                'cities' => $cities,
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function signup(Register $request)
    {
        $this->authService->signup($request);
        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function companyRegisterForm()
    {
        $cities = $this->cityService->collection();
        return view('frontend.auth.register', [
            'cities' => $cities,
        ]);
    }



    public function adminDashboard()
    {
        return view('backend.pages.dashboard');
    }

    public function companyDashboard()
    {
        return view('backend.pages.dashboard');
    }

    public function forgotPassword()
    {
        if (!Auth::user()) {
            return view('frontend.auth.forgot-password');
        } else {
            return redirect()->back();
        }
    }

    public function resetPassword(ForgotPassword $request)
    {
        $this->authService->resetPassword($request);
    }

    public function ResetPasswordForm($token)
    {
        if (!Auth::user()) {
            return view('frontend.auth.forget-password-link', ['token' => $token]);
        } else {
            return redirect()->back();
        }
    }

    public function submitReset(ResetPassword $request)
    {
        $this->authService->submitReset($request);
        return redirect()->route('login');
    }
}
