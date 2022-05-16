<?php

namespace App\Modules\Post\UnlikePost;

use App\Models\Like;
use Core\Domains\BaseJob;

class UnlikePostJob extends BaseJob
{
    /**
     * @param  UnlikePostDto  $dto
     */
    public function __construct(private UnlikePostDto $dto)
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
