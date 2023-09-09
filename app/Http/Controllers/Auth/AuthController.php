<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\Register;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompanyRegister;
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
        return view('admin.form.login');
    }

    public function signin(Login $request): RedirectResponse
    {

        $this->authservice->signin($request);

        if ($request->user()->role->firstWhere('name', 'admin')) {
            return redirect()->route('adminDashboard');
        } else if ($request->user()->role->firstWhere('name', 'company')) {
            return redirect()->route('companyDashboard');
        } else {
            return redirect()->route('homepage');
        }
    }

    public function register()
    {       
        return view('User.form.register', [
            'cities' => $this->cityservice->getAllCities()
        ]);
    }

    public function signup(Register $request)
    {
        $this->authservice->signup($request);
        // $validated = $request->validated();
        // $validated['password'] = Hash::make($validated['password']);

        // $user = User::create([
        //     'name' => $validated['name'],
        //     'password' => $validated['password'],
        //     'email' => $validated['email'],
        //     'city_id' => $validated['city_id'],
        //     'mobile_no' => $validated['mobile_no'],
        //     'status' =>  'pending'
        // ]);

        // $lastUserId = $user->id;

        // $user_role = RoleUser::create([
        //     'user_id' => $lastUserId,
        //     'role_id' => '3'
        // ]);

        // auth()->login($user);

        return redirect()->route('homepage');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function companyRegisterForm()
    {
        return view('User.form.register', [
            'cities' => $this->cityservice->getAllCities()
        ]);
    }

   

    public function adminDashboard()
    {
        return view('admin.pages.dashboard');
    }

    public function companyDashboard()
    {
        return view('User.pages.dashboard');
    }

    public function forgotPassword(){

    }
}
