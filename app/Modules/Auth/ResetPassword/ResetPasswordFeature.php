<?php

namespace App\Modules\Auth\ResetPassword;

use App\Models\User;
use Core\Services\BaseFeatures;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class ResetPasswordFeature extends BaseFeatures
{
    /**
     * @param  ResetPasswordRequest  $request
     * @return JsonResponse
     */
    public function handle(ResetPasswordRequest $request): JsonResponse
    {
        $user = $this->validateResettableUser($request);
        $this->validateResettableToken($request);
        $this->resetPassword($user, (string) $request->input('new_password'));

        return $this->success(new ResetPasswordTransformer($user));
    }

    /**
     * @param  User  $user
     * @param  string  $newPassword
     * @return void
     */
    protected function resetPassword(User $user, string $newPassword): void
    {
        $this->run(ResetPasswordJob::class, [
            'user'           => $user,
            'hashedPassword' => Hash::make($newPassword),
        ]);
    }

    /**
     * @param  ResetPasswordRequest  $request
     * @return void
     */
    protected function validateResettableToken(ResetPasswordRequest $request): void
    {
        $this->run(ValidateResettableToken::class, [
            'email' => (string) $request->input('email'),
            'token' => (string) $request->input('token'),
        ]);
    }

    /**
     * @param  ResetPasswordRequest  $request
     * @return User
     */
    protected function validateResettableUser(ResetPasswordRequest $request): User
    {
        /** @var User $user */
        $user = $this->run(GetSimpleUserJob::class, ['email' => (string) $request->input('email')]);

        if (!$user) {
            throw (new ModelNotFoundException())->setModel(User::class, [(string) $request->input('email')]);
        }

        return $user;
    }
}
