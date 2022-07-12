<?php

namespace App\Enums;

enum UserStatus: int
{
    case NEWBIE = 1;
    case NORMAL = 2;
    case PREMIUM = 3;
}
