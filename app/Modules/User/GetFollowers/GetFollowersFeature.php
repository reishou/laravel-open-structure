<?php

namespace App\Modules\User\GetFollowers;

use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetFollowersFeature extends BaseFeatures
{
    /**
     * @param  int  $userId
     */
    public function __construct(private int $userId)
    {
    }

    /**
     * @param  GetFollowersRequest  $request
     * @return JsonResponse
     */
    public function handle(GetFollowersRequest $request): JsonResponse
    {
        $data = $this->getFollowers($request, (int) Auth::id(), $this->userId);

        return $this->success(new GetFollowersTransformer($data));
    }

    /**
     * @param  GetFollowersRequest  $request
     * @param  int  $authenticatedUserId
     * @param  int  $userId
     * @return mixed
     */
    protected function getFollowers(GetFollowersRequest $request, int $authenticatedUserId, int $userId): mixed
    {
        return $this->run(GetFollowersJob::class, [
            'userId' => $userId,
            'limit'  => $this->getLimit($request),
            'with'   => [
                'user.profile',
                'user.followed' => function ($query) use ($authenticatedUserId) {
                    $query->where('user_id', $authenticatedUserId);
                }
            ],
        ]);
    }
}
