<?php

namespace App\Modules\Auth\Register;

use App\Models\User;
use Core\Domains\BaseJob;

class RegisterUserJob extends BaseJob
{
    /**
     * @param  RegisterUserDTO  $dto
     */
    public function __construct(private readonly RegisterUserDTO $dto)
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
