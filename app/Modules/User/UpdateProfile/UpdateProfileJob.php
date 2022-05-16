<?php

namespace App\Modules\User\UpdateProfile;

use App\Models\Profile;
use Core\Domains\BaseJob;

class UpdateProfileJob extends BaseJob
{
    public function __construct(private UpdateProfileDto $dto)
    {
    }

    /**
     * @return void
     */
    function handle(): void
    {
        Profile::where('user_id', $this->dto->userId)
            ->update($this->dto->updatable());
    }
}
