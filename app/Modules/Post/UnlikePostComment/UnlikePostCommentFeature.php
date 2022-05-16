<?php

namespace App\Modules\Post\UnlikePostComment;

use App\Enums\RelationMap;
use App\Models\Post;
use App\Models\PostComment;
use Core\Services\BaseFeatures;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UnlikePostCommentFeature extends BaseFeatures
{
    /**
     * @param  int  $postId
     * @param  int  $commentId
     */
    public function __construct(private int $postId, private int $commentId)
    {
    }

    /**
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function handle(): JsonResponse
    {
        $this->validateUnlikeableComment($this->postId, $this->commentId);
        $this->unlikeComment($this->commentId, (int) Auth::id());

        return $this->success(true);
    }

    /**
     * @param  int  $commentId
     * @param  int  $authenticatedUserId
     * @return void
     * @throws UnknownProperties
     */
    protected function unlikeComment(int $commentId, int $authenticatedUserId): void
    {
        $this->run(UnlikePostCommentJob::class, [
            'dto' => new UnlikePostCommentDto(
                userId: $authenticatedUserId,
                likeableId: $commentId,
                likeableType: RelationMap::POST_COMMENT
            )
        ]);
    }

    /**
     * @param  int  $postId
     * @param  int  $commentId
     * @return void
     */
    protected function validateUnlikeableComment(int $postId, int $commentId): void
    {
        $this->findOrFail(Post::class, $postId);
        /** @var PostComment $comment */
        $comment = $this->findOrFail(PostComment::class, $commentId);

        if ($comment->post_id != $postId) {
            throw (new ModelNotFoundException())->setModel(PostComment::class, [$commentId]);
        }
    }
}
