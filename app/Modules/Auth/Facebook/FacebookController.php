<?php

namespace App\Modules\Auth\Facebook;

use Core\Http\Controllers\Controller;

class FacebookController extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return $this->serve(FacebookFeature::class);
    }
}
