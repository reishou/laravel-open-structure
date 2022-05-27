<?php

namespace App\Modules\Auth\ForgetPassword;

use App\Models\User;
use Core\Domains\BaseJob;
use Illuminate\Support\Facades\Mail;

class SendMailForgetPasswordJob extends BaseJob
{
    /**
     * @param  User  $user
     * @param  string  $token
     */
    public function __construct(private User $user, private string $token)
    {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        Mail::to($this->user)->send(new ForgetPasswordMail($this->token));
    }
}
