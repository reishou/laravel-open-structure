<?php

namespace App\Modules\Post\CommentOnPost;

use Core\DataTransferObjects\Dto;
use Spatie\DataTransferObject\Attributes\MapTo;

class CommentOnPostDto extends Dto
{
    #[MapTo('user_id')]
    public int $userId;

    #[MapTo('post_id')]
    public int $postId;

    #[MapTo('content')]
    public string $content;
}
