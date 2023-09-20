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

    protected $authservice;
    protected $cityservice;
    protected $companyservice;

    public function __construct(AuthService $authservice, CompanyService $companyservice, CityService $cityservice)
    {
        $this->companyservice = $companyservice;
        $this->cityservice = $cityservice;
        $this->authservice = $authservice;
    }

    public function login()
    {
         return view('User.auth.login');       
    }

    public function signin(Login $request): RedirectResponse
    {
        $this->authservice->signIn($request);
        return redirect()->route('homepage');
    }

    public function register()
    {
        if (!Auth::user()) {
            return view('User.auth.register', [
                'cities' => $this->cityservice->getAllCities()
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function signup(Register $request)
    {
        $this->authservice->signup($request);
        return redirect()->route('homepage');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function companyRegisterForm()
    {
        return view('User.auth.register', [
            'cities' => $this->cityservice->getAllCities()
        ]);
    }



    public function adminDashboard()
    {
        return view('admin.pages.dashboard');
    }

    public function companyDashboard()
    {
        return view('company.pages.dashboard');
    }

    public function forgotPassword()
    {
        if (!Auth::user()) {
            return view('User.auth.forgotPassword');
        } else {
            return redirect()->back();
        }
    }

    public function resetPassword(ResetPassword $request)
    {
        $this->authservice->resetPassword($request);
    }

    public function ResetPasswordForm($token)
    {
        if (!Auth::user()) {
            return view('User.auth.forgetPasswordLink', ['token' => $token]);
        } else {
            return redirect()->back();
        }
    }

    public function submitReset(ResetPasswordPost $request)
    {
        $this->authservice->submitReset($request);
        return redirect()->route('login');
    }
}
