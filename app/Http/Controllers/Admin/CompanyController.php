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

    protected $companyService;
    protected $cityService;
    /**
     * Display a listing of the resource.
     */

    public function __construct(CompanyService $companyService, CityService $cityService)
    {
        $this->companyService = $companyService;
        $this->cityService = $cityService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $companies =  $this->companyService->collection();
            return $companies;
        }
        return view('company.pages.listing');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = $this->companyService->collection();

        return view('company.pages.edit', [
            'cities' => $cities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Add $request): RedirectResponse
    {
        $this->companyService->storeByAdmin($request);
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
            'cities' => $this->cityService->collection(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditCompany $request, Company $company)
    {
        $this->companyService->updateByAdmin($request, $company);
        return redirect()->route('admin.company.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        // dd($company->toArray());
        $delete = $company->delete();
        if ($delete == true) {
            return response()->json(['success' => true]);
            session()->flash('success', 'Event deleted successfully');
        } else {
            return response()->json('error');
            session()->flash('danger','There are some issues deleting company');
        }
        // return redirect()->route('admin.company.index');
    }
}
