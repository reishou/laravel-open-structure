<?php

namespace App\Modules\Feed\GetFeeds;

use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetFeedsFeature extends BaseFeatures
{
    /**
     * @param  GetFeedsRequest  $request
     * @return JsonResponse
     */
    public function handle(GetFeedsRequest $request): JsonResponse
    {
        $feeds = $this->getFeeds($request, (int) Auth::id());

        return $this->success(new GetFeedsTransformer($feeds));
    }

    /**
     * @param  GetFeedsRequest  $request
     * @param  int  $authenticatedUserId
     * @return mixed
     */
    protected function getFeeds(GetFeedsRequest $request, int $authenticatedUserId): mixed
    {
        return $this->run(GetFeedsJob::class, [
            'criteria' => [],
            'limit'    => $this->getLimit($request),
            'with'     => [
                'user',
                'likes',
                'comments',
                'liked' => function ($query) use ($authenticatedUserId) {
                    $query->where('user_id', $authenticatedUserId);
                },
            ],
        ]);
    }
}
