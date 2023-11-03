<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Create extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z]+(\s[a-zA-Z]+)?$/',
            'email' => 'required|email|unique:users,email',
            'company_name' => 'required|min:3|max:50',
            'description' => 'required|min:5|max:500',
            'address' => 'required|min:15|max:500',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'city_id' => 'required',
            'mobile_no' => 'required|numeric|digits:10|unique:users,mobile_no',
            'profile' => 'required|image|mimes:jpeg,jpg,png',
        ];
        
        if(Auth::check() == false){

        } elseif (Auth::user()->role_id == config('site.roles.admin')){
            $rules['status'] = 'required';
        }

        return $rules;

    }
}
