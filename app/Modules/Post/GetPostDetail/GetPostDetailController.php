<?php

namespace App\Modules\Post\GetPostDetail;

use Core\Http\Controllers\Controller;

class GetPostDetailController extends Controller
{
    /**
     * @param $id
     * @return mixed
     */
    public function __invoke($id): mixed
    {
        return $this->serve(GetPostDetailFeature::class, ['id' => (int) $id]);
    }
}
