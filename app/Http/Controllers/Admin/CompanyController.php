<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Create;
use App\Http\Requests\Company\Edit;
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


    public function store(Create $request): RedirectResponse
    {
        $this->companyService->store($request);
        return redirect()->route('admin.company.index');
    }

    public function edit(Company $company)
    {
        $cities = $this->cityService->collection();
        return view('backend.pages.company.edit', [
            'company' => $company,
            'cities' => $cities,
        ]);
    }

    public function update(Edit $request, Company $company)
    {
        $this->companyService->update($request, $company);
        return redirect()->route('admin.company.index');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json(['success' => true]);
    }
}
