<?php

namespace App\Modules\Feed\SearchImage;

use App\Models\PostImage;
use Core\Transformers\BaseTransformerCollection;

class SearchImageTransformer extends BaseTransformerCollection
{
    /**
     * @return array
     */
    public function data(): array
    {
        return $this->collection->transform(function (PostImage $image) {
            return [
                'post'   => [
                    'id'      => $image->post_id,
                    'content' => $image->post->content ?? null,
                ],
                'url'    => $image->url,
                'width'  => $image->width,
                'height' => $image->height,
            ];
        })
            ->toArray();
    }
}
