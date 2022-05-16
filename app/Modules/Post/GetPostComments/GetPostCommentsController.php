<?php

namespace App\Modules\Post\GetPostComments;

use Core\Http\Controllers\Controller;

class GetPostCommentsController extends Controller
{
    /**
     * @param  $postId
     * @return mixed
     */
    public function __invoke($postId): mixed
    {
        return $this->serve(GetPostCommentsFeature::class, ['postId' => (int) $postId]);
    }
}
