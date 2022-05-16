<?php

namespace App\Modules\User\GetProfile;

use Core\Http\Controllers\Controller;

class GetProfileController extends Controller
{
    /**
     * @param $userId
     * @return mixed
     */
    public function __invoke($userId): mixed
    {
        return $this->serve(GetProfileFeature::class, ['userId' => (int) $userId]);
    }
}
