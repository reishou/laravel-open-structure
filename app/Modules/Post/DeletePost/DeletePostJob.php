<?php

namespace App\Modules\Post\DeletePost;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostImage;
use Core\Domains\BaseJob;

class DeletePostJob extends BaseJob
{
    /**
     * @param  int  $id
     */
    public function __construct(private int $id)
    {
    }

    /**
     * @return void
     */
    function handle(): void
    {
        Post::where('id', $this->id)->delete();
        PostImage::where('post_id', $this->id)->delete();
        PostComment::where('post_id', $this->id)->delete();
    }
}
