<?php

namespace App\Modules\User\GetFollowers;

use App\Models\Follow;
use App\Models\User;
use Core\Transformers\BaseTransformerCollection;

class GetFollowersTransformer extends BaseTransformerCollection
{
    /**
     * @return array
     */
    public function data(): array
    {
        return $this->collection->transform(function (Follow $item) {
            /** @var User $follower */
            $follower = $item->user;

            return [
                'followed_at'      => $item->created_at->toAtomString(),
                'user_id'          => $item->user_id,
                'avatar_url'       => $follower->profile->avatar_url ?? null,
                'name'             => $follower->profile->name ?? null,
                'nickname'         => $follower->profile->nickname ?? null,
                'life_safety_id'   => $follower->profile->life_safety_id ?? null,
                'safety_sensor_id' => $follower->profile->safety_sensor_id ?? null,
                'is_followed'      => !empty($follower->followed),
            ];
        })
            ->toArray();
    }
}
