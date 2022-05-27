<?php

namespace App\Modules\Auth\ResetPassword;

use Core\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return $this->serve(ResetPasswordFeature::class);
    }
}
