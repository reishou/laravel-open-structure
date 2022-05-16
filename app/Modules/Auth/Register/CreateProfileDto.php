<?php

namespace App\Modules\Auth\Register;

use Core\DataTransferObjects\Dto;
use Spatie\DataTransferObject\Attributes\MapTo;

class CreateProfileDto extends Dto
{
    #[MapTo('user_id')]
    public int $userId;

    #[MapTo('name')]
    public string $name;

    #[MapTo('nickname')]
    public string $nickname;
}
