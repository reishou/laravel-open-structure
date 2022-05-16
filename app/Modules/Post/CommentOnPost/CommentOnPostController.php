<?php

namespace App\Modules\Post\CommentOnPost;

use Core\Http\Controllers\Controller;

class CommentOnPostController extends Controller
{
    /**
     * @param $postId
     * @return mixed
     */
    public function __invoke($postId): mixed
    {
        return $this->serve(CommentOnPostFeature::class, ['postId' => (int) $postId]);
    }
}
