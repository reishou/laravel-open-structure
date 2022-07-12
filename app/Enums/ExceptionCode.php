<?php

namespace App\Enums;

enum ExceptionCode: int
{
    // auth [1000-1999]
    case UNAUTHENTICATED = 1000;
    case UNAUTHORIZED = 1001;
    case REGISTER_EMAIL_UNIQUE = 1002;
    case LOGIN_FAIL = 1003;
}
