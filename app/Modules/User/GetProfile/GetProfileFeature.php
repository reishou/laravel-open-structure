<?php

namespace App\Modules\User\GetProfile;

use App\Models\User;
use Core\Models\BaseModel;
use Core\Services\BaseFeatures;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetProfileFeature extends BaseFeatures
{
    /**
     * @param  int  $userId
     */
    public function __construct(private readonly int $userId)
    {
    }

    /**
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        $profile = $this->getUser($this->userId, (int) Auth::id());

        return $this->success(new GetProfileTransformer($profile));
    }

    /**
     * @param  int  $userId
     * @param  int  $authenticatedUserId
     * @return Collection|BaseModel
     */
    protected function getUser(int $userId, int $authenticatedUserId): Collection|BaseModel
    {
        return $this->findOrFail(User::class, $userId, [
            'profile',
        ]);
    }
}
