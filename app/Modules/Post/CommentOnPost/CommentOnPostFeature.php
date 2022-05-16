<?php

namespace App\Modules\Post\CommentOnPost;

use App\Models\Post;
use App\Models\PostComment;
use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CommentOnPostFeature extends BaseFeatures
{
    /**
     * @param  int  $postId
     */
    public function __construct(private int $postId)
    {
    }

    /**
     * @param  CommentOnPostRequest  $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function handle(CommentOnPostRequest $request): JsonResponse
    {
        $this->validateCommentablePost($this->postId);
        $comment = $this->comment($request, $this->postId, (int) Auth::id());

        return $this->success($comment);
    }

    /**
     * @param  CommentOnPostRequest  $request
     * @param  int  $postId
     * @param  int  $authenticatedUserId
     * @return PostComment
     * @throws UnknownProperties
     */
    protected function comment(CommentOnPostRequest $request, int $postId, int $authenticatedUserId): PostComment
    {
        return $this->run(CommentOnPostJob::class, [
            'dto' => new CommentOnPostDto(
                userId: $authenticatedUserId,
                postId: $postId,
                content: (string) $request->input('content')
            )
        ]);
    }

    /**
     * @param  int  $postId
     * @return void
     */
    protected function validateCommentablePost(int $postId): void
    {
        $this->findOrFail(Post::class, $postId);
    }
}
