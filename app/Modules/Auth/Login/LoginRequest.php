<?php

namespace App\Modules\Auth\Login;

use Core\Http\Requests\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'    => 'required|string',
            'password' => 'required|string',
        ];
    }
}
