<?php

namespace App\Modules\Feed\SearchMap;

use Core\Http\Controllers\Controller;

class SearchMapController extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return $this->serve(SearchMapFeature::class);
    }
}
