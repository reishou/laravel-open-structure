<?php

namespace App\Modules\Auth\LoginFacebook;

use Core\Http\Requests\FormRequest;

class LoginFacebookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'access_token' => 'required|string'
        ];
    }
}
