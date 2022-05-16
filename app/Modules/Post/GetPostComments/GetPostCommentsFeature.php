<?php

namespace App\Modules\Post\GetPostComments;

use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetPostCommentsFeature extends BaseFeatures
{
    /**
     * @param  int  $postId
     */
    public function __construct(private int $postId)
    {
    }

    /**
     * @param  GetPostCommentsRequest  $request
     * @return JsonResponse
     */
    public function handle(GetPostCommentsRequest $request): JsonResponse
    {
        $comments = $this->getComments($request, $this->postId, (int) Auth::id());

        return $this->success(new GetPostCommentsTransformer($comments));
    }

    /**
     * @param  GetPostCommentsRequest  $request
     * @param  int  $postId
     * @param  int  $authenticatedUserId
     * @return mixed
     */
    protected function getComments(GetPostCommentsRequest $request, int $postId, int $authenticatedUserId): mixed
    {
        return $this->run(GetPostCommentsJob::class, [
            'criteria' => [
                'post_id' => $postId,
            ],
            'limit' => $this->getLimit($request),
            'with' => [
                'user',
                'likes',
                'liked' => function ($query) use ($authenticatedUserId) {
                    $query->where('user_id', $authenticatedUserId);
                }
            ]
        ]);
    }
}
