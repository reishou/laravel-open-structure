<?php

namespace App\Modules\Auth\Login;

use Core\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return $this->serve(LoginFeature::class);
    }
}
