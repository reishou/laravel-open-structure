<?php

namespace App\Modules\Auth\Register;

use App\Enums\ExceptionCode;
use App\Exceptions\BusinessException;
use App\Models\User;
use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Throwable;

class RegisterFeature extends BaseFeatures
{
    /**
     * @param  RegisterRequest  $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function handle(RegisterRequest $request): JsonResponse
    {
        $this->validateUserUnique($request);

        $user = DB::transaction(function () use ($request) {
            $user = $this->registerUser($request);
            $this->createProfile($user, $request);

            return $user;
        });

        return $this->success(new RegisterTransformer($user));
    }

    /**
     * @param  User  $user
     * @param  RegisterRequest  $request
     * @return void
     * @throws UnknownProperties
     */
    protected function createProfile(User $user, RegisterRequest $request): void
    {
        $this->run(CreateProfileJob::class, [
            'dto' => new CreateProfileDto(
                userId: $user->id,
                name: (string) $request->input('name'),
                nickname: (string) $request->input('nickname'),
            ),
        ]);
    }

    /**
     * @param  RegisterRequest  $request
     * @return void
     * @throws Throwable
     */
    protected function validateUserUnique(RegisterRequest $request): void
    {
        $user = $this->run(GetSimpleUserJob::class, ['email' => (string) $request->input('email')]);

        throw_if(
            $user,
            BusinessException::class,
            __('business.auth.email_unique'),
            ExceptionCode::REGISTER_EMAIL_UNIQUE
        );
    }

    /**
     * @param  RegisterRequest  $request
     * @return User
     * @throws UnknownProperties
     */
    protected function registerUser(RegisterRequest $request): User
    {
        return $this->run(RegisterUserJob::class, [
            'dto' => new RegisterUserDto(
                email: (string) $request->input('email'),
                hashedPassword: Hash::make((string) $request->input('password')),
            ),
        ]);
    }
}
