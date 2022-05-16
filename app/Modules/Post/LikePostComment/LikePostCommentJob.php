<?php

namespace App\Modules\Post\LikePostComment;

use App\Models\Like;
use Core\Domains\BaseJob;

class LikePostCommentJob extends BaseJob
{
    /**
     * @param  LikePostCommentDto  $dto
     */
    public function __construct(private LikePostCommentDto $dto)
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
