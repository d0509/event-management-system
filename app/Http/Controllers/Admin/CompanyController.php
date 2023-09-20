<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompanyRegister;
use App\Http\Requests\Company\Add;
use App\Http\Requests\Company\EditCompany;
use App\Models\City;
use App\Models\Company;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RoleUser;
use App\Models\User;
use App\Services\CityService;
use App\Services\CompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
   
    protected $companyservice;
    protected $cityservice;
    /**
     * Display a listing of the resource.
     */

    public function __construct(CompanyService $companyservice, CityService $cityservice)
    {
        $this->companyservice = $companyservice;
        $this->cityservice = $cityservice;
    }

    public function index()
    {
        $companies = $this->companyservice->getAllCompanies();
        return view('company.pages.listing', ['companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = $this->cityservice->getAllCities();

        return view('company.pages.edit', [
            'cities' => $cities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Add $request): RedirectResponse
{
    $this->companyservice->storeByAdmin($request);
    return redirect()->route('admin.company.index');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        // dd('admin.company.edit');
        return view('company.pages.edit', [
            'company' => $company,
            'cities' => $this->cityservice->getAllCities(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditCompany $request, Company $company)
    {
        $this->companyservice->updateByAdmin($request,$company);
        return redirect()->route('admin.company.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('admin.company.index');
    }
}
