<?php

namespace App\Modules\User\UnfollowUser;

use App\Enums\ExceptionCode;
use App\Enums\RelationMap;
use App\Exceptions\BusinessException;
use App\Models\User;
use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Throwable;

class UnfollowUserFeature extends BaseFeatures
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
        $this->validateUnfollowableUser((int) Auth::id(), $this->userId);
        $this->unfollowUser((int) Auth::id(), $this->userId);

        return $this->success(true);
    }

    /**
     * @param  int  $followerId
     * @param  int  $followingId
     * @return void
     * @throws Throwable
     */
    protected function validateUnfollowableUser(int $followerId, int $followingId): void
    {
        $this->findOrFail(User::class, $followingId);

        throw_if(
            $followerId == $followingId,
            BusinessException::class,
            __('business.user.unfollow_yourself'),
            ExceptionCode::YOU_CANNOT_UNFOLLOW_YOURSELF
        );
    }

    /**
     * @param  int  $followerId
     * @param  int  $followingId
     * @return void
     * @throws UnknownProperties
     */
    protected function unfollowUser(int $followerId, int $followingId): void
    {
        $this->run(UnfollowUserJob::class, [
            'dto' => new UnfollowUserDto(
                userId: $followerId,
                followableId: $followingId,
                followableType: RelationMap::USER,
            ),
        ]);
    }
}
