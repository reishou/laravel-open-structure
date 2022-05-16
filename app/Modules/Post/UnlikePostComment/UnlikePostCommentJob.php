<?php

namespace App\Modules\Post\UnlikePostComment;

use App\Models\Like;
use Core\Domains\BaseJob;

class UnlikePostCommentJob extends BaseJob
{
    /**
     * @param  UnlikePostCommentDto  $dto
     */
    public function __construct(private UnlikePostCommentDto $dto)
    {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        Like::where('user_id', $this->dto->userId)
            ->where('likeable_id', $this->dto->likeableId)
            ->where('likeable_type', $this->dto->likeableType)
            ->delete();
    }
}
