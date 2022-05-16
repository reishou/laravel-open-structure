<?php

namespace App\Modules\Post\UpdatePost;

use App\Models\Post;
use Core\Domains\BaseJob;

class UpdatePostJob extends BaseJob
{
    /**
     * @param  UpdatePostDto  $dto
     */
    public function __construct(private UpdatePostDto $dto)
    {
    }

    /**
     * @return void
     */
    function handle(): void
    {
        Post::where('id', $this->dto->id)
            ->update($this->dto->updatable());
    }
}
