<?php

namespace App\Modules\Auth\Register;

use Core\DataTransferObjects\DTO;
use Spatie\DataTransferObject\Attributes\MapTo;

class CreateProfileDTO extends DTO
{
    #[MapTo('id')]
    public int $id;

    #[MapTo('name')]
    public string $name;

    #[MapTo('nickname')]
    public string $nickname;
}
