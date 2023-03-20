<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
            'employee_name_kh' => 'required|max:255',
            'employee_name_en' => 'required|max:255',
            'date_of_birth' => 'required',
            'date_of_commencement' => 'required',
            'guarantee_letter' => 'required|nullable|mimes:pdf|max:2048',
            'employment_book' => 'required|nullable|mimes:pdf|max:2048',
            'personal_phone_number' => 'required|min:9|max:15',
            'email'     => 'required|string',
            // 'email'     => 'required|string|email|max:255|unique:users',
            'position_id' => 'required|string',
            'role_id' => 'required|string',
            'department_id' => 'required|string',
            'password' => [
                'sometimes',
                'nullable',
                'string',
                'confirmed'
            ]
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
