<?php

namespace App\Modules\Auth\ResetPassword;

use App\Models\User;
use Core\Transformers\BaseTransformer;
use Illuminate\Support\Carbon;

class ResetPasswordTransformer extends BaseTransformer
{
    /**
     * @return array
     */
    public function data(): array
    {
        /** @var User $user */
        $user = $this->resource;

        return [
            'id'           => $user->id,
            'name'         => $user->profile->name ?? null,
            'nickname'     => $user->profile->nickname ?? null,
            'email'        => $user->email,
            'avatar_url'   => $user->profile->avatar_url ?? null,
            'access_token' => $user->createToken('access_token')->plainTextToken,
            'token_type'   => 'bearer',
            'expires_at'   => Carbon::now()
                ->addMinutes(config('sanctum.access_token_expire'))
                ->toAtomString(),
        ];
    }
}
