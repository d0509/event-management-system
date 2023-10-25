<?php

namespace App\Http\Requests\CouponCode;

use Illuminate\Foundation\Http\FormRequest;

class Apply extends FormRequest
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
        return [
            'name' => 'required|regex:/^[A-Z0-9]*$/|exists:coupon_codes,name'
        ];
    }
}
