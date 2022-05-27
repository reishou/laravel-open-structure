<?php

namespace App\Modules\Auth\LoginFacebook;

use App\Models\Profile;
use App\Models\User;
use Core\Domains\BaseJob;
use Core\Utils\UniqueIdentity;
use Illuminate\Database\Eloquent\Model;
use Laravel\Socialite\Two\User as SocialiteTwoUser;

class LoginFacebookJob extends BaseJob
{
    /**
     * @param  SocialiteTwoUser  $socialiteTwoUser
     */
    public function __construct(private SocialiteTwoUser $socialiteTwoUser)
    {
    }

    /**
     * @return User
     */
    public function handle(): User
    {
        $user = $this->getUser($this->socialiteTwoUser);

        if ($user) {
            if (!$user->facebook_id) {
                $user->update(['facebook_id' => $this->socialiteTwoUser->getId()]);
            }

            return $user;
        }

        User::upsert(
            [
                [
                    'id'          => UniqueIdentity::id(1),
                    'email'       => $this->socialiteTwoUser->getEmail(),
                    'facebook_id' => $this->socialiteTwoUser->getId(),
                ],
            ],
            ['facebook_id'],
            ['email'],
        );

        $user = $this->getUser($this->socialiteTwoUser);

        $this->createProfile($this->socialiteTwoUser, $user);

        return $user;
    }

    /**
     * @param  SocialiteTwoUser  $socialiteTwoUse
     * @param  User  $user
     * @return void
     */
    protected function createProfile(SocialiteTwoUser $socialiteTwoUse, User $user): void
    {
        Profile::create([
            'user_id'  => $user->id,
            'name'     => $socialiteTwoUse->getName(),
            'nickname' => $socialiteTwoUse->getNickname(),
        ]);
    }

    /**
     * @param  SocialiteTwoUser  $socialiteTwoUser
     * @return User|Model|null
     */
    protected function getUser(SocialiteTwoUser $socialiteTwoUser): User|Model|null
    {
        return User::useWritePdo()
            ->where(function ($query) use ($socialiteTwoUser) {
                $query->where('email', $socialiteTwoUser->getEmail())
                    ->orWhere('facebook_id', $socialiteTwoUser->getId());
            })
            ->first();
    }
}
