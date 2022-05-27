<?php

namespace App\Modules\Auth\ResetPassword;

use Core\Http\Requests\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'        => 'required|string',
            'token'        => 'required|string',
            'new_password' => 'required|string|min:6|max:255|regex:/(^[A-Za-z0-9 ]+$)+/',
        ];
    }
}
