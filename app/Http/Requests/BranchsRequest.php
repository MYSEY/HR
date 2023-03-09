<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchsRequest extends FormRequest
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
            'branch_name_kh' => 'required|string|max:255',
            'branch_name_en' => 'required|string|max:255',
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
            'branch_name_kh.required'   => 'The branch name khmer field is required.'
        ];
    }
}
