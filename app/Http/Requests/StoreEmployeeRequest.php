<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'department_id' => 'required|exists:department,department_id',
            'position_id' => 'required|exists:position,position_id',
            'salary' => 'required|numeric|min:0',
            'driving_license_path' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'background_check_path' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'photo_path' => 'nullable|image|mimes:jpg,png|max:2048',
        ];
    }
}
