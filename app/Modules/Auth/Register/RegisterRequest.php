<?php

namespace App\Modules\Auth\Register;

use App\Infrastructure\Requests\FormRequest;
use Illuminate\Support\Facades\Hash;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'    => 'required|email:rfc,dns',
            'password' => 'required|string',
        ];
    }

    public function dto(): RegisterDTO
    {
        $password = (string) $this->input('password');

        return new RegisterDTO((string) $this->input('email'), Hash::make($password));
    }
}
