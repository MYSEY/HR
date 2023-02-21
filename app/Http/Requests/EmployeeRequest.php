<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'guarantee_letter' => 'required|mimes:pdf|max:2048',
            // 'branch_id' => 'required|integer',
            // 'position_id' => 'required',
            // 'department_id' => 'required|integer',
            'personal_phone_number' => 'required|min:9|max:15',
            // 'current_addtress'       => 'sometimes|nullable|numeric',
            'email'          => 'required|email',
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
