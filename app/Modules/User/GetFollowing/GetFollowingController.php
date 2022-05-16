<?php

namespace App\Modules\User\GetFollowing;

use Core\Http\Controllers\Controller;

class GetFollowingController extends Controller
{
    /**
     * @param $userId
     * @return mixed
     */
    public function __invoke($userId): mixed
    {
        return $this->serve(GetFollowingFeature::class, ['userId' => (int) $userId]);
    }
}
