<?php

namespace App\Modules\User\UpdateProfile;

use App\Enums\ExceptionCode;
use App\Enums\FileDirectoryType;
use App\Exceptions\BusinessException;
use App\Models\User;
use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UpdateProfileFeature extends BaseFeatures
{
    /**
     * @param  int  $userId
     */
    public function __construct(private int $userId)
    {
    }

    /**
     * @param  UpdateProfileRequest  $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function handle(UpdateProfileRequest $request): JsonResponse
    {
        $this->validateUpdatableProfile((int) Auth::id(), $this->userId);

        $avatar = (string) $request->input('avatar');
        if (!empty($avatar)) {
            $this->validateUploadableAvatar($avatar, FileDirectoryType::AVATAR, (int) Auth::id());
            $this->uploadAvatar($avatar, FileDirectoryType::AVATAR, (int) Auth::id());
        }

        $this->updateProfile($request, $this->userId);

        return $this->success(true);
    }

    /**
     * @param  string  $avatar
     * @param  string  $directoryType
     * @param  int  $authenticatedUserId
     * @return void
     */
    protected function uploadAvatar(string $avatar, string $directoryType, int $authenticatedUserId): void
    {
        $this->moveFromTempToDestination([$avatar], $directoryType, $authenticatedUserId);
    }

    /**
     * @param  string  $avatar
     * @param  string  $directoryType
     * @param  int  $authenticatedUserId
     * @return void
     */
    public function validateUploadableAvatar(string $avatar, string $directoryType, int $authenticatedUserId): void
    {
        $this->checkTempFileExists([$avatar], $directoryType, $authenticatedUserId);
    }

    /**
     * @param  int  $authenticatedUserId
     * @param  int  $userId
     * @return void
     * @throws Throwable
     */
    protected function validateUpdatableProfile(int $authenticatedUserId, int $userId): void
    {
        $this->findOrFail(User::class, $userId);

        throw_if(
            $userId != $authenticatedUserId,
            BusinessException::class,
            __('business.user.profile_access_denied'),
            ExceptionCode::PROFILE_ACCESS_DENIED,
            Response::HTTP_FORBIDDEN
        );
    }

    /**
     * @param  UpdateProfileRequest  $request
     * @param  int  $userId
     * @return void
     * @throws UnknownProperties
     */
    protected function updateProfile(UpdateProfileRequest $request, int $userId): void
    {
        $avatar = (string) $request->input('avatar');
        if (!empty($avatar)) {
            $avatar = FileDirectoryType::getStorageDirectory(FileDirectoryType::AVATAR, $userId).'/'.$avatar;
        }

        $this->run(UpdateProfileJob::class, [
            'dto' => new UpdateProfileDto(
                userId: $userId,
                name: (string) $request->input('name'),
                nickname: (string) $request->input('nickname'),
                avatar: $avatar,
                description: (string) $request->input('description')
            ),
        ]);
    }
}
