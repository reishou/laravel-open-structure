<?php

namespace App\Modules\Post\LikePost;

use Core\DataTransferObjects\Dto;
use Spatie\DataTransferObject\Attributes\MapTo;

class LikePostDto extends Dto
{
    #[MapTo('user_id')]
    public int $userId;

    #[MapTo('likeable_id')]
    public int $likeableId;

    #[MapTo('likeable_type')]
    public string $likeableType;
}
