<?php

namespace App\Modules\User\UnfollowUser;

use Core\Http\Controllers\Controller;

class UnfollowUserController extends Controller
{
    /**
     * @param $userId
     * @return mixed
     */
    public function __invoke($userId): mixed
    {
        return $this->serve(UnfollowUserFeature::class, ['userId' => (int) $userId]);
    }
}
