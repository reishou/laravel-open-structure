<?php

namespace App\Enums;

use Core\Enums\Enum;

class ExceptionCode extends Enum
{
    // auth [1000-1999]
    public const UNAUTHENTICATED       = 1000;
    public const UNAUTHORIZED          = 1001;
    public const REGISTER_EMAIL_UNIQUE = 1002;
    public const LOGIN_FAIL            = 1003;

    // user [2000-2999]
    public const PROFILE_ACCESS_DENIED        = 2000;
    public const YOU_CANNOT_FOLLOW_YOURSELF   = 2001;
    public const YOU_CANNOT_UNFOLLOW_YOURSELF = 2002;

    // post [3000-3999]
    public const POST_ACCESS_DENIED         = 3000;
    public const POST_COMMENT_ACCESS_DENIED = 3001;
}
