<?php

namespace App\Modules\Auth\LoginFacebook;

use Core\Domains\BaseJob;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteTwoUser;

class GetFacebookUserJob extends BaseJob
{
    /**
     * @param  string  $accessToken
     */
    public function __construct(private string $accessToken)
    {
    }

    /**
     * @return SocialiteTwoUser|null
     */
    public function handle(): ?SocialiteTwoUser
    {
        try {
            return Socialite::driver('facebook')
                ->userFromToken($this->accessToken);
        } catch (Exception) {
            return null;
        }

    }
}
