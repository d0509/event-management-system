<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class AddEvent extends FormRequest
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
            'city_id' => 'required',
            'name' => 'required',
            'description'=>'required',
            'available_seat'=>'required|integer|min:1',
            'venue'=>'required',
            'start_time'=>'required|date_format:H:i',
            'end_time'=>'required|date_format:H:i|after:time_start',
            'ticket'=>'required',
            'banner'=>'required|image',
            'event_date' => 'required',
        ];
    }
}
