<?php

namespace App\Modules\Post\CommentOnPost;

use App\Models\PostComment;
use Core\Domains\BaseJob;

class CommentOnPostJob extends BaseJob
{
    /**
     * @param  CommentOnPostDto  $dto
     */
    public function __construct(private CommentOnPostDto $dto)
    {
    }

    /**
     * @return PostComment
     */
    public function handle(): PostComment
    {
        return PostComment::create($this->dto->toArray());
    }
}
