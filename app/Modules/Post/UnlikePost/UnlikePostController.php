<?php

namespace App\Modules\Post\UnlikePost;

use Core\Http\Controllers\Controller;

class UnlikePostController extends Controller
{
    /**
     * @param $id
     * @return mixed
     */
    public function __invoke($id): mixed
    {
        return $this->serve(UnlikePostFeature::class, ['id' => (int) $id]);
    }
}
