<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class Register extends FormRequest
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
                'name' => 'required|string|max:255|regex:/^[a-zA-Z]+(\s[a-zA-Z]+)?$/',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|confirmed',
                'password_confirmation'=>'required',
                'city_id'=>'required',
                'mobile_no'=>'required|numeric|digits:10|unique:users,mobile_no',
                'profile' => 'required'
            ];
    }
}
