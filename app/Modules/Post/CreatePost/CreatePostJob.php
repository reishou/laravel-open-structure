<?php

namespace App\Modules\Post\CreatePost;

use App\Models\Post;
use Core\Domains\BaseJob;

class CreatePostJob extends BaseJob
{
    /**
     * @param  CreatePostDto  $dto
     */
    public function __construct(private CreatePostDto $dto)
    {
    }

    /**
     * @return Post
     */
    public function handle(): Post
    {
        return Post::create($this->dto->toArray());
    }
}
