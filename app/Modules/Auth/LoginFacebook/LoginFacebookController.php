<?php

namespace App\Modules\Auth\LoginFacebook;

use Core\Http\Controllers\Controller;

class LoginFacebookController extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return $this->serve(LoginFacebookFeature::class);
    }
}
