<?php

namespace App\Modules\Auth\Logout;

use Core\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return $this->serve(LogoutFeature::class);
    }
}
