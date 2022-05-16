<?php

namespace App\Modules\Post\CreatePost;

use Core\Http\Controllers\Controller;

class CreatePostController extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return $this->serve(CreatePostFeature::class);
    }
}
