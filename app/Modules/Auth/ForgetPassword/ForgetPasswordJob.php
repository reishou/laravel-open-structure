<?php

namespace App\Modules\Auth\ForgetPassword;

use App\Models\User;
use Core\Domains\BaseJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgetPasswordJob extends BaseJob
{
    /**
     * @param  User  $user
     */
    public function __construct(private User $user)
    {
    }

    /**
     * @return string
     */
    public function handle(): string
    {
        $token = $this->generateToken();
        $this->saveToken($this->user, $token);

        return $token;
    }

    /**
     * @param  User  $user
     * @param  string  $token
     * @return void
     */
    protected function saveToken(User $user, string $token): void
    {
        DB::table('password_resets')
            ->updateOrInsert(
                ['email' => $user->email],
                [
                    'token'      => Hash::make($token),
                    'created_at' => Carbon::now(),
                ],
            );
    }

    /**
     * @return string
     */
    protected function generateToken(): string
    {
        $min = pow(10, 5);

        return (string) mt_rand($min, 10 * $min - 1);
    }
}
