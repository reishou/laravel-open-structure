<?php

namespace App\Modules\Feed\GetFeeds;

use Core\Http\Controllers\Controller;

class GetFeedsController extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return $this->serve(GetFeedsFeature::class);
    }
}
