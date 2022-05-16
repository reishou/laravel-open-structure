<?php

namespace App\Modules\Auth\Facebook;

use Core\Transformers\BaseTransformer;
use Core\Utils\UniqueIdentity;
use Faker\Factory;
use Illuminate\Support\Carbon;

class FacebookTransformer extends BaseTransformer
{
    /**
     * @return array
     */
    public function data(): array
    {
        $faker = Factory::create();

        return [
            'id'           => UniqueIdentity::id(1),
            'name'         => $faker->name,
            'nickname'     => $faker->userName,
            'email'        => $faker->email,
            'avatar_url'   => $faker->imageUrl,
            'access_token' => base64_encode($faker->md5),
            'token_type'   => 'bearer',
            'expires_at'   => Carbon::now()
                ->addMinutes(config('sanctum.access_token_expire'))
                ->toIso8601String(),
        ];
    }
}
