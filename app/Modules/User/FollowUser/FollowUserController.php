<?php

namespace App\Modules\User\FollowUser;

use Core\Http\Controllers\Controller;

class FollowUserController extends Controller
{
    /**
     * @param $userId
     * @return mixed
     */
    public function __invoke($userId): mixed
    {
        return $this->serve(FollowUserFeature::class, ['userId' => (int) $userId]);
    }
}
