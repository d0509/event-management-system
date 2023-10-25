<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CouponCode;
use Illuminate\Http\Request;

class CouponCodeStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // dd($request);
        $coupon  = CouponCode::find($request->id);
        // dd($coupon->is_active);

        $updated_status  = $coupon->is_active == '1' ? '0' : '1';
        // dd($updated_status);

        $coupon->update([
            'is_active' => $updated_status,
        ]);

        return response()->json(['success' => true]);
    }
}
