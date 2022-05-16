<?php

namespace App\Modules\Auth\Facebook;

use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;

class FacebookFeature extends BaseFeatures
{
    public function handle(): JsonResponse
    {
        return $this->success(new FacebookTransformer(true));
    }
}
