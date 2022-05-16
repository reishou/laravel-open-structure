<?php

namespace App\Modules\Feed\SearchImage;

use Core\Http\Controllers\Controller;

class SearchImageController extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return $this->serve(SearchImageFeature::class);
    }
}
