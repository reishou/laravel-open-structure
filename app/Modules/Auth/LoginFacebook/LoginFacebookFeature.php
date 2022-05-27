<?php

namespace App\Modules\Auth\LoginFacebook;

use App\Enums\ExceptionCode;
use App\Exceptions\BusinessException;
use App\Models\User;
use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Two\User as SocialiteTwoUser;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LoginFacebookFeature extends BaseFeatures
{
    /**
     * @param  LoginFacebookRequest  $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function handle(LoginFacebookRequest $request): JsonResponse
    {
        $socialiteTwoUser = $this->getFacebookUser((string) $request->input('access_token'));

        $user = $this->loginFacebook($socialiteTwoUser);

        return $this->success(new LoginFacebookTransformer($user));
    }

    /**
     * @param  string  $accessToken
     * @return SocialiteTwoUser
     * @throws Throwable
     */
    protected function getFacebookUser(string $accessToken): SocialiteTwoUser
    {
        $socialiteTwoUser = $this->run(GetFacebookUserJob::class, ['accessToken' => $accessToken]);

        throw_unless(
            $socialiteTwoUser,
            BusinessException::class,
            __('business.auth.login_facebook_fail'),
            ExceptionCode::LOGIN_FACEBOOK_FAIL,
            Response::HTTP_UNAUTHORIZED
        );

        return $socialiteTwoUser;
    }

    /**
     * @param  SocialiteTwoUser  $socialiteTwoUser
     * @return User
     */
    protected function loginFacebook(SocialiteTwoUser $socialiteTwoUser): User
    {
        return $this->run(LoginFacebookJob::class, [
            'socialiteTwoUser' => $socialiteTwoUser,
        ]);
    }
}
