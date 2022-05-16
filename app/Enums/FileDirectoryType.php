<?php

namespace App\Enums;

use Core\Enums\FileDirectoryType as BaseFileDirectoryType;

class FileDirectoryType extends BaseFileDirectoryType
{
    public const POST_IMAGE = 'post_image';
    public const AVATAR     = 'avatar';
}
