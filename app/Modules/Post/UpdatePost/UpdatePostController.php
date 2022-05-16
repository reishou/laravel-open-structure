<?php

namespace App\Modules\Post\UpdatePost;

use Core\Http\Controllers\Controller;

class UpdatePostController extends Controller
{
    /**
     * @param $id
     * @return mixed
     */
    public function __invoke($id): mixed
    {
        return $this->serve(UpdatePostFeature::class, ['id' => (int) $id]);
    }
}
