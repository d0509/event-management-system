<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Add;
use App\Http\Requests\Company\EditCompany;
use App\Models\Company;
use App\Services\CityService;
use App\Services\CompanyService;
use Illuminate\Http\RedirectResponse;

class CompanyController extends Controller
{

    protected $companyService;
    protected $cityService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->cityService = new CityService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $companies =  $this->companyService->collection();
            return $companies;
        }
        return view('backend.pages.company.index');
    }


    public function create()
    {
        $cities = $this->cityService->collection();

        return view('backend.pages.company.edit', [
            'cities' => $cities,
        ]);
    }


    public function store(Add $request): RedirectResponse
    {
        $this->companyService->storeByAdmin($request);
        return redirect()->route('admin.company.index');
    }

    public function edit(Company $company)
    {
        // dd('admin.company.edit');
        return view('backend.pages.company.edit', [
            'company' => $company,
            'cities' => $this->cityService->collection(),
        ]);
    }

    public function update(EditCompany $request, Company $company)
    {
        $this->companyService->updateByAdmin($request, $company);
        return redirect()->route('admin.company.index');
    }

    public function destroy(Company $company)
    {
        $delete = $company->delete();
        if ($delete == true) {
            return response()->json(['success' => true]);
        } else {
            return response()->json('error');
        }
    }
}
