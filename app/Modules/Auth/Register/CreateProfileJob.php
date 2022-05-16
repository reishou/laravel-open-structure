<?php

namespace App\Modules\Auth\Register;

use App\Models\Profile;
use Core\Domains\BaseJob;

class CreateProfileJob extends BaseJob
{
    public function __construct(private CreateProfileDto $dto)
    {
    }

    /**
     * @return Profile
     */
    public function handle(): Profile
    {
        return Profile::create($this->dto->toArray());
    }
}
