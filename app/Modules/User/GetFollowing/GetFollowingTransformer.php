<?php

namespace App\Modules\User\GetFollowing;

use App\Models\Follow;
use App\Models\User;
use Core\Transformers\BaseTransformerCollection;

class GetFollowingTransformer extends BaseTransformerCollection
{
    /**
     * @return array
     */
    public function data(): array
    {
        return $this->collection->transform(function (Follow $item) {
            /** @var User $following */
            $following = $item->followable;

            return [
                'followed_at'      => $item->created_at->toAtomString(),
                'user_id'          => $item->followable_id,
                'avatar_url'       => $following->profile->avatar_url ?? null,
                'name'             => $following->profile->name ?? null,
                'nickname'         => $following->profile->nickname ?? null,
                'life_safety_id'   => $following->profile->life_safety_id ?? null,
                'safety_sensor_id' => $following->profile->safety_sensor_id ?? null,
                'is_followed'      => !empty($following->followed),
            ];
        })
            ->toArray();
    }
}
