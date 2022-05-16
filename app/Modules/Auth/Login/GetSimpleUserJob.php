<?php

namespace App\Modules\Auth\Login;

use App\Models\User;
use Core\Domains\BaseJob;

class GetSimpleUserJob extends BaseJob
{
    /**
     * @param  string|null  $email
     */
    public function __construct(private ?string $email)
    {
    }

    /**
     * @return User|null
     */
    public function handle(): User|null
    {
        $query = User::query();

        if (!$this->email) {
            return null;
        }

        $query->where('email', $this->email);

        return $query->first();
    }
}
