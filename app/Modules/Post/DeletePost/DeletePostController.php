<?php

namespace App\Modules\Post\DeletePost;

use Core\Http\Controllers\Controller;

class DeletePostController extends Controller
{
    /**
     * @param $id
     * @return mixed
     */
    public function __invoke($id): mixed
    {
        return $this->serve(DeletePostFeature::class, ['id' => (int) $id]);
    }
}
