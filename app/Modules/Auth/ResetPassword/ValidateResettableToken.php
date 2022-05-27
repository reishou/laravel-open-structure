<?php

namespace App\Modules\Auth\ResetPassword;

use App\Enums\ExceptionCode;
use App\Exceptions\BusinessException;
use Core\Domains\BaseJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class ValidateResettableToken extends BaseJob
{
    /**
     * @param  string  $email
     * @param  string  $token
     */
    public function __construct(private string $email, private string $token)
    {
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function handle(): void
    {
        $reset = DB::table('password_resets')
            ->where('email', $this->email)
            ->first();

        throw_if(
            !$reset
            || !Hash::check($this->token, $reset->token)
            || $this->tokenExpired($reset->created_at),
            BusinessException::class,
            __('business.auth.email_or_token_reset_password_invalid'),
            ExceptionCode::EMAIL_OR_TOKEN_RESET_PASSWORD_INVALID
        );
    }

    /**
     * @param $createdAt
     * @return bool
     */
    protected function tokenExpired($createdAt): bool
    {
        $expires = config("auth.passwords.users.expire");

        return Carbon::parse($createdAt)->addSeconds($expires * 60)->isPast();
    }
}
