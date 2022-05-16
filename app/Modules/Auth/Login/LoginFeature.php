<?php

namespace App\Modules\Auth\Login;

use App\Enums\ExceptionCode;
use App\Exceptions\BusinessException;
use App\Models\User;
use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LoginFeature extends BaseFeatures
{
    /**
     * @param  LoginRequest  $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function handle(LoginRequest $request): JsonResponse
    {
        $user = $this->login($request);

        return $this->success(new LoginTransformer($user));
    }

    /**
     * @param  LoginRequest  $request
     * @return User
     * @throws Throwable
     */
    protected function login(LoginRequest $request): User
    {
        /** @var User $user */
        $user = $this->run(GetSimpleUserJob::class, ['email' => (string) $request->input('email')]);

        throw_unless(
            $user && Hash::check((string) $request->input('password'), $user->password),
            BusinessException::class,
            __('business.auth.login_fail'),
            ExceptionCode::LOGIN_FAIL,
            Response::HTTP_UNAUTHORIZED
        );

        return $user;
    }
}
