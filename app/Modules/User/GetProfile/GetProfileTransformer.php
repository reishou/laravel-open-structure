<?php

namespace App\Modules\User\GetProfile;

use App\Models\User;
use Core\Transformers\BaseTransformer;

class GetProfileTransformer extends BaseTransformer
{
    /**
     * @return array
     */
    public function data(): array
    {
        /** @var User $user */
        $user = $this->resource;

        return [
            'id'               => $user->id,
            'name'             => $user->profile->name ?? null,
            'nickname'         => $user->profile->nickname ?? null,
            'email'            => $user->email,
            'avatar_url'       => $user->profile->avatar_url ?? null,
            'description'      => $user->profile->description ?? null,
            'life_safety_id'   => $user->profile->life_safety_id ?? null,
            'safety_sensor_id' => $user->profile->safety_sensor_id ?? null,
            'is_followed'      => !empty($user->followed),
            'total_posts'      => $user->posts->count(),
            'total_followers'  => $user->followers->count(),
            'total_following'  => $user->following->count(),
        ];
    }
}
