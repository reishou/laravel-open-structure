<?php

namespace App\Enums;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;

enum RelationMap: string
{
    case USER = 'user';

    /**
     * Setup morphMap by enum const
     *
     * @return void
     */
    public static function morphMap(): void
    {
        Relation::morphMap([
            self::USER->value => User::class,
        ]);
    }
}

