<?php

namespace App\Services;

use App\Models\CouponCode;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CouponCodeService
{
    public function collection()
    {
        $data = CouponCode::select('id', 'name', 'usable_count', 'percentage', 'start_date', 'end_date','company_id','is_active')->with(['company'])->where('company_id',Auth::user()->company->id)->latest();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $editURL = route('company.coupon-code.edit', ['coupon_code' => $row->id]);

                $btn = '<div class="d-flex"><a class="text-white w-3 btn btn-primary mr-2" href="'.$editURL.'" > <i class="fa-solid fa-pen-to-square"></i></a><a class="delete_coupon text-white w-3 btn btn-danger" id="delete_target_' . $row->id . '" data-id="' . $row->id . '" onclick="deleteCoupons(' . $row->id . ')" class="text-white w-3 btn btn-danger mr-2"> <i class="fa-solid fa-trash"></i></a></div>';
                return $btn;
            })
            ->addColumn('is_active',function($row){
                $status  = $row->is_active;
                $condition = $status == 1 ? 'checked' : '';
                $switch = '
                <div class="form-check form-switch text-center " >
                <input class="form-check-input" type="checkbox" data-couponId="' . $row->id . '"  role="switch" id="flexSwitchCheckChecked" ' . $condition . '>
                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                </div>';
                return $switch;
            })
            ->orderColumn('name',function($query,$order){
                $query->orderBy('id',$order);
            })
            ->rawColumns(['action','is_active'])
            ->setRowId('id')
            ->addIndexColumn()
            ->make(true);

        return true;
    }

    public function destroy($coupon_code)
    {
       $coupon_code->delete();
    }

    public function store($request)
    {
        $validated = $request->validated();
        $Coupon = CouponCode::create([
            'company_id' => Auth::user()->company->id,
            'name' => $validated['name'],
            'usable_count' => $validated['usable_count'],
            'percentage' => $validated['percentage'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date']
        ]);

        if ($Coupon) {
            session()->flash('success', 'Coupon Added Successfully');
        } else {
            session()->flash('danger','There are some issues adding coupon code');
        }
    }

    public function update($request,$coupon_code){


        $coupon_code->update([
            'name' => $request->name,
            'usable_count' => $request->usable_count,
            'percentage' => $request->percentage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        session()->flash('success','Coupon updated successfully');
    }

    public function changeStatus($request){
        $coupon  = CouponCode::find($request->id);
        $updated_status  = $coupon->is_active == '1' ? '0' : '1';

        $coupon->update([
            'is_active' => $updated_status,
        ]);

        return response()->json(['success' => true]);
    }
}
