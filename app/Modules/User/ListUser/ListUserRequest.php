<?php

namespace App\Modules\User\ListUser;

use App\Infrastructure\Criteria\UserCriteria;
use Illuminate\Http\Request;

class ListUserRequest extends Request
{
    public function criteria(): UserCriteria
    {
        return new UserCriteria();
    }
}
