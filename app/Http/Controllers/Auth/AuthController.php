<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\Register;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompanyRegister;
use App\Http\Requests\Auth\ResetPassword;
use App\Http\Requests\Auth\ResetPasswordPost;
use App\Models\City;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Company;
use App\Models\RoleUser;
use App\Models\User;
use App\Services\AuthService;
use App\Services\CityService;
use App\Services\CompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{

    protected $authService;
    protected $cityService;
    protected $companyService;

    public function __construct(AuthService $authService, CompanyService $companyService, CityService $cityService)
    {
        $this->companyService = $companyService;
        $this->cityService = $cityService;
        $this->authService = $authService;
    }

    public function login()
    {
        // dd(redirect()->back());
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
            return view('frontend.auth.register', [
                'cities' => $this->cityService->collection()
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
        return view('frontend.auth.register', [
            'cities' => $this->cityService->collection()
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

    public function resetPassword(ResetPassword $request)
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

    public function submitReset(ResetPasswordPost $request)
    {
        $this->authService->submitReset($request);
        return redirect()->route('login');
    }
}
