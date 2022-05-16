<?php

namespace App\Modules\Post\LikePost;

use App\Models\Like;
use Core\Domains\BaseJob;

class LikePostJob extends BaseJob
{
    /**
     * @param  LikePostDto  $dto
     */
    public function __construct(private LikePostDto $dto)
    {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        Like::upsert(
            $this->dto->toArray(),
            ['user_id', 'likeable_id', 'likeable_type']
        );
    }
}
