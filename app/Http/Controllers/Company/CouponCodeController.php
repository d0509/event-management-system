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

    public function edit(string $id)
    {
        $coupon = CouponCode::where('id',$id)->first();
        return view('backend.pages.coupon-code.create',[
            'coupon' => $coupon,
        ]);
    }

    public function update(Store $request, string $id)
    {
        $this->couponCodeService->update($request,$id);
        return redirect()->route('company.coupon-code.index');
    }

    public function destroy(string $id)
    {
       $delete = $this->couponCodeService->destroy($id);
        if ($delete) {
            session()->flash('success','Inquiry deleted successfully');
            return response()->json(['success' => true]);
        } 
    }
}
