<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyStatusController extends Controller
{
    protected $companyService;

    public function __construct(CompanyService $companyService){
        $this->companyService = $companyService;
    }

    public function __invoke(Request $request)
    {
        return $this->companyService->changeStatus($request->id);
    }
}
