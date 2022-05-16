<?php

namespace App\Modules\Post\UnlikePostComment;

use Core\Http\Controllers\Controller;

class UnlikePostCommentController extends Controller
{
    /**
     * @param $postId
     * @param $commentId
     * @return mixed
     */
    public function __invoke($postId, $commentId): mixed
    {
        return $this->serve(UnlikePostCommentFeature::class, [
            'postId'    => (int) $postId,
            'commentId' => (int) $commentId,
        ]);
    }
}
