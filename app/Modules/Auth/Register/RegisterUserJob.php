<?php

namespace App\Modules\Auth\Register;

use App\Models\User;
use Core\Domains\BaseJob;

class RegisterUserJob extends BaseJob
{
    /**
     * @param  RegisterUserDto  $dto
     */
    public function __construct(private RegisterUserDto $dto)
    {
    }

    /**
     * @return User
     */
    public function handle(): User
    {
        return User::create($this->dto->toArray());
    }
}
