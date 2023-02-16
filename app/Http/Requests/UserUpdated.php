<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdated extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'required',
            'position_id' => 'required',
            'department_id' => 'required',
            'date_of_birth' => 'required',
            'password' => [
                'sometimes',
                'nullable',
                'string',
                'confirmed'
            ]
        ];
    }
}
