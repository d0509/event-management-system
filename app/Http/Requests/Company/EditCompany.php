<?php

namespace App\Http\Requests\Company;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EditCompany extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email'=>['required','email', Rule::unique('users')->ignore($this->company->user)],
            'company_name' => 'required|min:3|max:50',
            'description' => 'required|min:5|max:5000',
            'address' => 'required|max:500',
            'city_id'=>'required',
            'mobile_no'=>['required','numeric','digits:10', Rule::unique('users')->ignore($this->company->user)],
            'status'=>'required',
            'profile' => 'nullable|image'
        ];
    }
}
