<?php

namespace App\Enums;

use App\Models\User;
use Core\Enums\Enum;
use Illuminate\Database\Eloquent\Relations\Relation;

class RelationMap extends Enum
{
    public const USER         = 'user';
    public const POST         = 'post';
    public const POST_COMMENT = 'post_comment';

    /**
     * Setup morphMap by enum const
     *
     * @return void
     */
    public static function morphMap(): void
    {
        Relation::morphMap([
            self::USER => User::class,
        ]);
    }
}
