<?php

namespace App\Modules\Post\CreatePost;

use App\Models\Post;
use Core\Transformers\BaseTransformer;
use Core\Utils\UniqueIdentity;
use Faker\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class CreatePostTransformer extends BaseTransformer
{
    /**
     * @return array
     */
    public function data(): array
    {
        /** @var Post $post */
        $post = $this->resource;

        return Arr::only($post->toArray(), [
            'id',
            'content',
            'caught_fish_at',
            'fish_species',
            'fish_size',
            'total_fishes',
            'latitude',
            'longitude',
        ]);
    }
}
