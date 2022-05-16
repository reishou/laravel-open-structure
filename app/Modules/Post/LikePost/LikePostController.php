<?php

namespace App\Modules\Post\LikePost;

use Core\Http\Controllers\Controller;

class LikePostController extends Controller
{
    /**
     * @param $id
     * @return mixed
     */
    public function __invoke($id): mixed
    {
        return $this->serve(LikePostFeature::class, ['id' => $id]);
    }
}
