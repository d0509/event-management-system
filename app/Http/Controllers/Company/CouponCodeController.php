<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponCode\Store;
use App\Models\CouponCode;
use App\Services\CouponCodeService;
use Illuminate\Http\Request;

class CouponCodeController extends Controller
{
    protected $couponCodeService;

    public function __construct(CouponCodeService $couponCodeService)
    {
        $this->couponCodeService = $couponCodeService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $couponCode =  $this->couponCodeService->collection();
            return $couponCode;
        }
        return view('backend.pages.coupon-code.index');
    }

    public function create()
    {
        return view('backend.pages.coupon-code.create');
    }


    public function store(Store $request)
    {
        $this->couponCodeService->store($request);
        return redirect()->route('company.coupon-code.index');
    }

    public function edit(CouponCode $coupon_code)
    {
        return view('backend.pages.coupon-code.create', [
            'coupon_code' => $coupon_code,
        ]);
    }

    public function update(Store $request, CouponCode $coupon_code)
    {
        $this->couponCodeService->update($request, $coupon_code);
        return redirect()->route('company.coupon-code.index');
    }

    public function destroy(CouponCode $coupon_code)
    {
        $this->couponCodeService->destroy($coupon_code);
        return response()->json(['success' => true]);
    }
}
