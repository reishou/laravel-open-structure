<?php

namespace App\Modules\Post\UnlikePostComment;

use Core\DataTransferObjects\DTO;
use Spatie\DataTransferObject\Attributes\MapTo;

class UnlikePostCommentDto extends DTO
{
    #[MapTo('user_id')]
    public int $userId;

    #[MapTo('likeable_id')]
    public int $likeableId;

    #[MapTo('likeable_type')]
    public string $likeableType;
}
