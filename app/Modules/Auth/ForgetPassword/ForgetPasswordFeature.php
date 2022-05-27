<?php

namespace App\Modules\Auth\ForgetPassword;

use App\Models\User;
use Core\Services\BaseFeatures;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ForgetPasswordFeature extends BaseFeatures
{
    public function handle(ForgetPasswordRequest $request): JsonResponse
    {
        $user  = $this->validateForgettableUser($request);
        $token = $this->forgetPassword($user);
//        $this->notify($user, $token);

        return $this->success($token);
    }

    /**
     * @param  ForgetPasswordRequest  $request
     * @return User
     */
    protected function validateForgettableUser(ForgetPasswordRequest $request): User
    {
        /** @var User $user */
        $user = $this->run(GetSimpleUserJob::class, ['email' => (string) $request->input('email')]);

        if (!$user) {
            throw (new ModelNotFoundException())->setModel(User::class, [(string) $request->input('email')]);
        }

        return $user;
    }

    /**
     * @param  User  $user
     * @param  string  $token
     * @return void
     */
    protected function notify(User $user, string $token): void
    {
        $this->run(SendMailForgetPasswordJob::class, [
            'user'  => $user,
            'token' => $token,
        ]);
    }

    /**
     * @param  User  $user
     * @return string
     */
    protected function forgetPassword(User $user): string
    {
        return $this->run(ForgetPasswordJob::class, [
            'user' => $user,
        ]);
    }
}
