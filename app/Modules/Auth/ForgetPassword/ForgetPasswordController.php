<?php

namespace App\Modules\Auth\ForgetPassword;

use Core\Http\Controllers\Controller;

class ForgetPasswordController extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return $this->serve(ForgetPasswordFeature::class);
    }
}
