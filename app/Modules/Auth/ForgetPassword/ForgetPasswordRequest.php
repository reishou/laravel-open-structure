<?php

namespace App\Modules\Auth\ForgetPassword;

use Core\Http\Requests\FormRequest;

class ForgetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email:rfc,dns|max:255',
        ];
    }
}
