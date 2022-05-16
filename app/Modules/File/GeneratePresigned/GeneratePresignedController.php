<?php

namespace App\Modules\File\GeneratePresigned;

use Core\Http\Controllers\Controller;

class GeneratePresignedController extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return $this->serve(GeneratePresignedFeature::class);
    }
}
