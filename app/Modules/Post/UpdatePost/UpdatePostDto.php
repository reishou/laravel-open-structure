<?php

namespace App\Modules\Post\UpdatePost;

use Core\DataTransferObjects\Dto;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Attributes\MapTo;

class UpdatePostDto extends Dto
{
    #[MapTo('id')]
    public int $id;

    #[MapTo('content')]
    public ?string $content;

    #[MapTo('caught_fish_at')]
    public ?Carbon $caughtFishAt;

    #[MapTo('fish_species')]
    public ?string $fishSpecies;

    #[MapTo('fish_size')]
    public ?string $fishSize;

    #[MapTo('total_fishes')]
    public ?int $totalFishes;

    #[MapTo('latitude')]
    public ?string $latitude;

    #[MapTo('longitude')]
    public ?string $longitude;

    #[MapTo('location')]
    public ?string $location;
}
