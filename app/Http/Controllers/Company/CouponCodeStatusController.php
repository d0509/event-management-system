<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CouponCode;
use Illuminate\Http\Request;

class CouponCodeStatusController extends Controller
{
   public function __invoke(Request $request)
    {
        $coupon  = CouponCode::find($request->id);
        $updated_status  = $coupon->is_active == '1' ? '0' : '1';

        $coupon->update([
            'is_active' => $updated_status,
        ]);

        return response()->json(['success' => true]);
    }
}
