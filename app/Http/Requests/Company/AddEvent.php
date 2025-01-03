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
        $rules = [
            'city_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'available_seat' => 'required|integer|min:10',
            'venue' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'ticket' => 'required',
            'event_date' => 'required| after:now',
            'location' => 'required',
            'banner' => 'required'
        ];


        if ($this->event) {
            $rules['banner'] = 'nullable|image';
            // $rules['is_approved'] = 'required';
        } else {
            $rules['banner'] = 'image|required';
            // $rules['is_approved'] = 0;
        }

        return $rules;
    }
}
