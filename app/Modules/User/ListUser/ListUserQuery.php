<?php

namespace App\Modules\User\ListUser;

use App\Infrastructure\Criteria\UserCriteria;
use App\Infrastructure\ReadModels\User;

class ListUserQuery
{
    /**
     * @var User
     */
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function query(UserCriteria $criteria)
    {
//        $this->user->newQuery()->where('');

        return [];
    }
}
