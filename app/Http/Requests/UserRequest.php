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
            'txtFirstName'   => "required|min:2",
            'txtLastName'    => "required|min:2",
            'txtEmail'       => "required|email",
            'txtPass'        => "required|min:6|",
            'txtConfirmPass' => "required|same:txtPass",         //Same:txtpass bắt buộc phải giống txtpass 
       
        ];
    }
}
