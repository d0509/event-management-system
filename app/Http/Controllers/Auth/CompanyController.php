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
    protected $cityService;
    protected $companyService;

    public function __construct(CompanyService $companyService, CityService $cityService)
    {
        $this->companyService = $companyService;
        $this->cityService = $cityService;
    }

    public function create()
    {
        if(!Auth::user()){
            return view('frontend.auth.register', [
                'cities' => $this->cityService->collection()
            ]);
        } else {
            return redirect()->back();
        }
       
    }

    public function store(CompanyRegister $request): RedirectResponse
    {
        
        $this->companyService->registeredByCompany($request);
        return redirect()->route('guest.company.create');
    }
}
