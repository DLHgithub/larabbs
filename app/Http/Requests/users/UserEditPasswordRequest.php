<?php

namespace App\Http\Requests\users;

use Illuminate\Foundation\Http\FormRequest;

class UserEditPasswordRequest extends FormRequest
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
            'password_old' => 'required|min:6|max:50',
            'password' => 'required|min:6|max:50|confirmed'
        ];
    }

    public function attributes()
    {
        return [
            'password_old' => '旧密码'
        ];
    }
}
