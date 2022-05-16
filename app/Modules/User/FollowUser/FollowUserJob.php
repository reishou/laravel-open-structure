<?php

namespace App\Modules\User\FollowUser;

use App\Models\Follow;
use Core\Domains\BaseJob;

class FollowUserJob extends BaseJob
{
    public function __construct(private FollowUserDto $dto)
    {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        Follow::upsert(
            $this->dto->toArray(),
            ['user_id', 'followable_id', 'followable_type']
        );
    }
}
