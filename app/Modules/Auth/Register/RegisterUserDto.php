<?php

namespace App\Modules\Auth\Register;

use Core\DataTransferObjects\Dto;
use Spatie\DataTransferObject\Attributes\MapTo;

class RegisterUserDto extends Dto
{
    #[MapTo('email')]
    public string $email;

    #[MapTo('password')]
    public string $hashedPassword;
}
