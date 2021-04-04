<?php

namespace App\Modules\Auth\Register;

use App\Infrastructure\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;

class RegisterRequest extends FormRequest
{
    #[ArrayShape(['email' => "string", 'password' => "string"])]
    public function rules(): array
    {
        return [
            'email'    => 'required|email:rfc,dns',
            'password' => 'required|string',
        ];
    }

    /**
     * @return RegisterDTO
     */
    public function dto(): RegisterDTO
    {
        $password = (string) $this->input('password');

        return new RegisterDTO((string) $this->input('email'), Hash::make($password));
    }
}
