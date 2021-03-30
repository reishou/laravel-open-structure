<?php

namespace App\Modules\Auth\Register;

use App\Infrastructure\DataTransferObjects\DTO;

class RegisterDTO extends DTO
{
    private string $email;
    private string $password;

    /**
     * RegisterDTO constructor.
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email    = $email;
        $this->password = $password;
    }
}
