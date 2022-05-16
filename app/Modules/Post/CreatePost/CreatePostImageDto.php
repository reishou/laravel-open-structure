<?php

namespace App\Modules\Post\CreatePost;

use Core\DataTransferObjects\Dto;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Attributes\MapTo;

class CreatePostImageDto extends Dto
{
    #[MapTo('post_id')]
    public int $postId;

    #[MapTo('path')]
    public string $path;

    #[MapTo('width')]
    public int $width;

    #[MapTo('height')]
    public int $height;

    #[MapTo('created_at')]
    public Carbon $createdAt;

    #[MapTo('updated_at')]
    public Carbon $updatedAt;
}
