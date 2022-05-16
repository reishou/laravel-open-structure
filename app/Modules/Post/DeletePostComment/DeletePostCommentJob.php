<?php

namespace App\Modules\Post\DeletePostComment;

use App\Models\PostComment;
use Core\Domains\BaseJob;

class DeletePostCommentJob extends BaseJob
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
        PostComment::where('id', $this->id)->delete();
    }
}
