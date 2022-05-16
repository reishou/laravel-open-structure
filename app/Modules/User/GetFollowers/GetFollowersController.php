<?php

namespace App\Modules\User\GetFollowers;

use Core\Http\Controllers\Controller;

class GetFollowersController extends Controller
{
    /**
     * @param $userId
     * @return mixed
     */
    public function __invoke($userId): mixed
    {
        return $this->serve(GetFollowersFeature::class, ['userId' => (int) $userId]);
    }
}
