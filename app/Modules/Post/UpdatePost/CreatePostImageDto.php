<?php

namespace App\Modules\Post\UpdatePost;

use Core\DataTransferObjects\Dto;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Attributes\MapTo;

class CreatePostImageDto extends Dto
{
    #[MapTo('post_id')]
    public int $postId;

    #[MapTo('path')]
    public string $path;

    #[MapTo('created_at')]
    public Carbon $createdAt;

    #[MapTo('updated_at')]
    public Carbon $updatedAt;
}
