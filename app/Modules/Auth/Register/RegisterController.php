<?php

namespace App\Modules\Auth\Register;

use Core\Http\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return $this->serve(RegisterFeature::class);
    }
}
