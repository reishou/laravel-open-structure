<?php

namespace App\Modules\User\UpdateProfile;

use Core\DataTransferObjects\Dto;
use Spatie\DataTransferObject\Attributes\MapTo;

class UpdateProfileDto extends Dto
{
    #[MapTo('user_id')]
    public int $userId;

    #[MapTo('name')]
    public ?string $name;

    #[MapTo('nickname')]
    public ?string $nickname;

    #[MapTo('avatar')]
    public ?string $avatar;

    #[MapTo('description')]
    public ?string $description;
}
