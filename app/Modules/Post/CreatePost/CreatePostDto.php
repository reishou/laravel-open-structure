<?php

namespace App\Modules\Post\CreatePost;

use Core\DataTransferObjects\Dto;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Attributes\MapTo;

class CreatePostDto extends Dto
{
    #[MapTo('user_id')]
    public int $userId;

    #[MapTo('content')]
    public string $content;

    #[MapTo('caught_fish_at')]
    public Carbon $caughtFishAt;

    #[MapTo('fish_species')]
    public string $fishSpecies;

    #[MapTo('fish_size')]
    public string $fishSize;

    #[MapTo('total_fishes')]
    public int $totalFishes;

    #[MapTo('latitude')]
    public ?string $latitude;

    #[MapTo('longitude')]
    public ?string $longitude;

    #[MapTo('location')]
    public ?string $location;
}
