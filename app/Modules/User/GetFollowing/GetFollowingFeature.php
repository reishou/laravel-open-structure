<?php

namespace App\Modules\User\GetFollowing;

use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetFollowingFeature extends BaseFeatures
{
    /**
     * @param  int  $userId
     */
    public function __construct(private int $userId)
    {
    }

    /**
     * @param  GetFollowingRequest  $request
     * @return JsonResponse
     */
    public function handle(GetFollowingRequest $request): JsonResponse
    {
        $data = $this->getFollowers($request, (int) Auth::id(), $this->userId);

        return $this->success(new GetFollowingTransformer($data));
    }

    /**
     * @param  GetFollowingRequest  $request
     * @param  int  $authenticatedUserId
     * @param  int  $userId
     * @return mixed
     */
    protected function getFollowers(GetFollowingRequest $request, int $authenticatedUserId, int $userId): mixed
    {
        return $this->run(GetFollowingJob::class, [
            'userId' => $userId,
            'limit'  => $this->getLimit($request),
            'with'   => [
                'followable.profile',
                'followable.followed' => function ($query) use ($authenticatedUserId) {
                    $query->where('user_id', $authenticatedUserId);
                }
            ],
        ]);
    }
}
