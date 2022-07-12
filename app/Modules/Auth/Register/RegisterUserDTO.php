<?php

namespace App\Modules\Auth\Register;

use App\Enums\UserStatus;
use Core\DataTransferObjects\DTO;
use Spatie\DataTransferObject\Attributes\MapTo;

class RegisterUserDTO extends DTO
{
    #[MapTo('email')]
    public string $email;

    #[MapTo('password')]
    public string $hashedPassword;

    #[MapTo('status')]
    public UserStatus $status;
}
