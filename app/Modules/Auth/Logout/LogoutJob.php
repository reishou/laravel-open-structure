<?php

namespace App\Modules\Auth\Logout;

use App\Models\User;
use Core\Domains\BaseJob;

class LogoutJob extends BaseJob
{
    /**
     * @param  User  $user
     */
    public function __construct(private User $user)
    {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->user->currentAccessToken()->delete();
    }
}
