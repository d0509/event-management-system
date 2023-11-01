<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CouponCode;
use App\Services\CouponCodeService;
use Illuminate\Http\Request;

class CouponCodeStatusController extends Controller
{
    protected $couponCodeService;

    public function __construct(CouponCodeService $couponCodeService)
    {
        $this->couponCodeService = $couponCodeService;  
    }
   public function __invoke(Request $request)
    {
        return $this->couponCodeService->changeStatus($request);        
    }
}
