<?php

namespace App\Modules\Feed\SearchMap;

use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;

class SearchMapFeature extends BaseFeatures
{
    public function handle(): JsonResponse
    {
        return $this->success(new SearchMapTransformer(true));
    }
}
