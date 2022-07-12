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
            'id'         => $user->id,
            'email'      => $user->email,
            'status'     => $user->status,
            'name'       => $user->profile->name ?? null,
            'nickname'   => $user->profile->nickname ?? null,
            'avatar_url' => $user->profile->avatar_url ?? null,
        ];
    }
}
