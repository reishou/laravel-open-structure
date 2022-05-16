<?php

namespace App\Modules\Post\DeletePostComment;

use Core\Http\Controllers\Controller;

class DeletePostCommentController extends Controller
{
    /**
     * @param $postId
     * @param $commentId
     * @return mixed
     */
    public function __invoke($postId, $commentId): mixed
    {
        return $this->serve(DeletePostCommentFeature::class, [
            'postId'    => (int) $postId,
            'commentId' => (int) $commentId,
        ]);
    }
}
