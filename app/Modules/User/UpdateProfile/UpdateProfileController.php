<?php

namespace App\Modules\User\UpdateProfile;

use Core\Http\Controllers\Controller;

class UpdateProfileController extends Controller
{
    /**
     * @param $userId
     * @return mixed
     */
    public function __invoke($userId): mixed
    {
        return $this->serve(UpdateProfileFeature::class, ['userId' => (int) $userId]);
    }
}
