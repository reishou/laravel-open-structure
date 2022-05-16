<?php

namespace App\Modules\Post\GetPostComments;

use App\Models\PostComment;
use Core\Transformers\BaseTransformerCollection;

class GetPostCommentsTransformer extends BaseTransformerCollection
{
    /**
     * @return array
     */
    public function data(): array
    {
        return $this->collection->transform(function (PostComment $item) {
            return [
                'id'          => $item->id,
                'content'     => $item->content,
                'created_at'  => $item->created_at->toAtomString(),
                'user'        => [
                    'id'         => $item->user_id,
                    'name'       => $item->user->profile->name ?? null,
                    'nickname'   => $item->user->profile->nickname ?? null,
                    'avatar_url' => $item->user->profile->avatar_url ?? null,
                ],
                'is_liked'    => !empty($item->liked),
                'total_likes' => $item->likes->count(),
            ];
        })
            ->toArray();
    }
}
