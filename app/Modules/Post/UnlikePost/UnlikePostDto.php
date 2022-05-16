<?php

namespace App\Modules\Post\UnlikePost;

use Core\DataTransferObjects\Dto;
use Spatie\DataTransferObject\Attributes\MapTo;

class UnlikePostDto extends Dto
{
    #[MapTo('user_id')]
    public int $userId;

    #[MapTo('likeable_id')]
    public int $likeableId;

    #[MapTo('likeable_type')]
    public string $likeableType;
}
