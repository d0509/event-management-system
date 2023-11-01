<?php

namespace App\Http\Requests\CouponCode;

use App\Models\Coupon;
use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // dd($this->input('coupon_id'));
        $couponId = $this->input('coupon_id');
        $companyId = $this->input('company_id');
        $rules = [
            'company_id' => 'required|exists:companies,id',
            'usable_count' => 'required|numeric',
            'percentage' => 'required|numeric|min:1|max:99',
            'start_date' => 'required|date|after:yesterday|before:end_date',
            'end_date' => 'required|after:start_date',
        ];

        if($couponId){
            $rules['name'] = 'required|regex:/^[A-Z0-9][A-Z\-0-9]*$/u|unique:coupon_codes,name,'.$companyId.',company_id';
        } else {
            $rules['name'] =  'required|regex:/^[A-Z0-9][\[A-Z\-0-9\]]*$/u|unique:coupon_codes,name,NULL,id,company_id,'.$companyId;
        }

        return $rules;
       
    }
}

