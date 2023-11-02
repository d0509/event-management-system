<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Create;
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
            $cities =  $this->cityService->collection();
            return view('frontend.auth.register', [
                'cities' =>$cities
            ]);
        } else {
            return redirect()->back();
        }       
    }

    public function store(Create $request): RedirectResponse
    {        
        $this->companyService->store($request);
        return redirect()->route('company.create');
    }
}
