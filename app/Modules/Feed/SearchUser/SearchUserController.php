<?php

namespace App\Modules\Feed\SearchUser;

use Core\Http\Controllers\Controller;

class SearchUserController extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return $this->serve(SearchUserFeature::class);
    }
}
