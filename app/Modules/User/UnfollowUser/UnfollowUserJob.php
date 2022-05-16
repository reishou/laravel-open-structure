<?php

namespace App\Modules\User\UnfollowUser;

use App\Models\Follow;
use Core\Domains\BaseJob;

class UnfollowUserJob extends BaseJob
{
    public function __construct(private UnfollowUserDto $dto)
    {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        Follow::where('user_id', $this->dto->userId)
            ->where('followable_id', $this->dto->followableId)
            ->where('followable_type', $this->dto->followableType)
            ->delete();
    }
}
