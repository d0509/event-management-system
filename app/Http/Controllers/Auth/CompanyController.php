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
use Illuminate\Support\Facades\Auth;
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
        if(!Auth::user()){
            return view('User.auth.register', [
                'cities' => $this->cityservice->collection()
            ]);
        } else {
            return redirect()->back();
        }
       
    }

    public function store(CompanyRegister $request): RedirectResponse
    {
        
        $this->companyservice->registeredByCompany($request);
        return redirect()->route('guest.company.create');
    }
}
