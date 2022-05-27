<?php

namespace App\Modules\Auth\ResetPassword;

use App\Models\User;
use Core\Domains\BaseJob;
use Illuminate\Support\Facades\DB;

class ResetPasswordJob extends BaseJob
{
    /**
     * @param  User  $user
     * @param  string  $hashedPassword
     */
    public function __construct(private User $user, private string $hashedPassword)
    {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->user->update(['password' => $this->hashedPassword]);
        $this->user->tokens()->delete();
        DB::table('password_resets')
            ->where('email', $this->user->email)
            ->delete();
    }
}
