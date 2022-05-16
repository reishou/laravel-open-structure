<?php

namespace App\Modules\Post\LikePostComment;

use Core\Http\Controllers\Controller;

class LikePostCommentController extends Controller
{
    /**
     * @param $postId
     * @param $commentId
     * @return mixed
     */
    public function __invoke($postId, $commentId): mixed
    {
        return $this->serve(LikePostCommentFeature::class, [
            'postId'    => (int) $postId,
            'commentId' => (int) $commentId,
        ]);
    }
}
