<?php

namespace App\Modules\User\FollowUser;

use App\Enums\ExceptionCode;
use App\Enums\RelationMap;
use App\Exceptions\BusinessException;
use App\Models\User;
use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Throwable;

class FollowUserFeature extends BaseFeatures
{
    /**
     * @param  int  $userId
     */
    public function __construct(private int $userId)
    {
    }

    /**
     * @return JsonResponse
     * @throws Throwable
     * @throws UnknownProperties
     */
    public function handle(): JsonResponse
    {
        $this->validateFollowableUser((int) Auth::id(), $this->userId);
        $this->followUser((int) Auth::id(), $this->userId);

        return $this->success(true);
    }

    /**
     * @param  int  $followerId
     * @param  int  $followingId
     * @return void
     * @throws Throwable
     */
    protected function validateFollowableUser(int $followerId, int $followingId): void
    {
        $this->findOrFail(User::class, $followingId);

        throw_if(
            $followerId == $followingId,
            BusinessException::class,
            __('business.user.follow_yourself'),
            ExceptionCode::YOU_CANNOT_FOLLOW_YOURSELF
        );
    }

    /**
     * @param  int  $followerId
     * @param  int  $followingId
     * @return void
     * @throws UnknownProperties
     */
    protected function followUser(int $followerId, int $followingId): void
    {
        $this->run(FollowUserJob::class, [
            'dto' => new FollowUserDto(
                userId: $followerId,
                followableId: $followingId,
                followableType: RelationMap::USER,
            ),
        ]);
    }
}
