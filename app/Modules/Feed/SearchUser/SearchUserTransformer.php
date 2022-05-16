<?php

namespace App\Modules\Feed\SearchUser;

use App\Models\User;
use Core\Transformers\BaseTransformerCollection;

class SearchUserTransformer extends BaseTransformerCollection
{
    /**
     * @return array
     */
    public function data(): array
    {
        return $this->collection->transform(function (User $user) {
            return [
                'id'               => $user->id,
                'name'             => $user->profile->name ?? null,
                'nickname'         => $user->profile->nickname ?? null,
                'avatar_url'       => $user->profile->avatar_url ?? null,
                'life_safety_id'   => $user->profile->life_safety_id ?? null,
                'safety_sensor_id' => $user->profile->safety_sensor_id ?? null,
                'is_followed'      => !empty($user->followed),
            ];
        })
            ->toArray();
    }
}
