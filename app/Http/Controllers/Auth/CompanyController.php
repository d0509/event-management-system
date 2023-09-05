<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompanyRegister;
use App\Models\Company;
use App\Models\RoleUser;
use App\Models\User;
use App\Services\CityService;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    protected $cityservice;
    protected $companyservice;

    public function __construct(CompanyService $companyService, CityService $cityservice)
    {
        $this->companyservice = $companyService;
        $this->cityservice = $cityservice;
    }

    public function create()
    {
        return view('User.form.register', [
            'cities' => $this->cityservice->getAllCities()
        ]);
    }

    public function store(CompanyRegister $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create([
            'name' => $validated['name'],
            'password' => $validated['password'],
            'email' => $validated['email'],
            'city_id' => $validated['city_id'],
            'mobile_no' => $validated['mobile_no'],
            'status' =>  'pending'
        ]);

        $lastUserId = $user->id;

        $company = Company::create([
            'user_id' => $lastUserId,
            'address' => $validated['address'],
            'description' => $validated['description'],
            'name' => $validated['company_name']
        ]);

        $user_role = RoleUser::create([
            'user_id' => $lastUserId,
            'role_id' => '2'
        ]);

        auth()->login($user);

        return redirect()->route('companyDashboard');
    }
}
