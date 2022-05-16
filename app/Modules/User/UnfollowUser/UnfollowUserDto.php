<?php

namespace App\Modules\User\UnfollowUser;

use Core\DataTransferObjects\Dto;
use Spatie\DataTransferObject\Attributes\MapTo;

class UnfollowUserDto extends Dto
{
    #[MapTo('user_id')]
    public int $userId;

    #[MapTo('followable_id')]
    public int $followableId;

    #[MapTo('followable_type')]
    public string $followableType;
}
