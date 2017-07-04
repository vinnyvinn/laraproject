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
        $rules = [
            'username' => 'required|unique:users',
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        if ($this->method() == 'PUT') {
            $rules['username'] = 'required|unique:users,username,' . $this->user;
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $this->user;
            $rules['password'] = 'nullable|min:6|confirmed';
        }

        return $rules;
    }
}
