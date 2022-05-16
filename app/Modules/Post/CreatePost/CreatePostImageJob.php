<?php

namespace App\Modules\Post\CreatePost;

use App\Models\PostImage;
use Core\Domains\BaseJob;
use Illuminate\Support\Collection;

class CreatePostImageJob extends BaseJob
{
    /**
     * @param  Collection  $collection
     */
    public function __construct(private Collection $collection)
    {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        PostImage::insert($this->collection->toArray());
    }
}
