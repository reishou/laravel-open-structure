<?php

namespace App\Modules\Post\GetPostDetail;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostImage;
use Core\Transformers\BaseTransformer;
use Illuminate\Support\Arr;

class GetPostDetailTransformer extends BaseTransformer
{
    /**
     * @return array
     */
    public function data(): array
    {
        /** @var Post $post */
        $post = $this->resource;

        $data = Arr::only($post->toArray(), [
            'id',
            'content',
            'caught_fish_at',
            'fish_species',
            'fish_size',
            'total_fishes',
            'latitude',
            'longitude',
        ]);

        $images = $post->images->map(function (PostImage $image) {
            return [
                'url'    => $image->url,
                'width'  => $image->width,
                'height' => $image->height,
            ];
        });

        $topComments = $post->topComments->map(function (PostComment $comment) {
            return [
                'id'         => $comment->id,
                'content'    => $comment->content,
                'created_at' => $comment->created_at->toAtomString(),
                'user'       => [
                    'id'         => $comment->user_id,
                    'name'       => $comment->user->profile->name ?? null,
                    'nickname'   => $comment->user->profile->nickname ?? null,
                    'avatar_url' => $comment->user->profile->avatar_url ?? null,
                ],
                'is_liked'   => !empty($comment->liked),
            ];
        });

        return array_merge($data, [
            'images'         => $images,
            'total_likes'    => $post->likes->count(),
            'total_comments' => $post->comments->count(),
            'is_liked'       => !empty($post->liked),
            'user'           => [
                'id'               => $post->user_id,
                'name'             => $post->user->profile->name ?? null,
                'nickname'         => $post->user->profile->nickname ?? null,
                'avatar_url'       => $post->user->profile->avatar_url ?? null,
                'life_safety_id'   => $post->user->profile->life_safety_id ?? null,
                'safety_sensor_id' => $post->user->profile->safety_sensor_id ?? null,
                'is_followed'      => !empty($post->user->followed),
            ],
            'top_comments'   => $topComments,
        ]);
    }
}
