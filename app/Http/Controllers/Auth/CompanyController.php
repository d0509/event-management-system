<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompanyRegister;
use App\Services\CityService;
use App\Services\CompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    protected $cityService;
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->cityService = new CityService();
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
