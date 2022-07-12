<?php

namespace App\Modules\Auth\Register;

use Core\Http\Requests\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'    => 'required|email:rfc,dns|max:255',
            'password' => 'required|string|min:6|max:255|regex:/(^[A-Za-z0-9 ]+$)+/',
            'name'     => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:255',
        ];
    }
}
