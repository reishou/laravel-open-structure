<?php

namespace App\Modules\Post\DeletePostComment;

use App\Enums\ExceptionCode;
use App\Exceptions\BusinessException;
use App\Models\Post;
use App\Models\PostComment;
use Core\Services\BaseFeatures;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DeletePostCommentFeature extends BaseFeatures
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
     * @throws Throwable
     * @throws UnknownProperties
     */
    public function handle(): JsonResponse
    {
        $this->validateDeletableComment($this->postId, $this->commentId, (int) Auth::id());
        $this->deleteComment($this->commentId);

        return $this->success(true);
    }

    /**
     * @param  int  $commentId
     * @return void
     */
    protected function deleteComment(int $commentId): void
    {
        $this->run(DeletePostCommentJob::class, ['id' => $commentId]);
    }

    /**
     * @param  int  $postId
     * @param  int  $commentId
     * @param  int  $authenticatedUserId
     * @return void
     * @throws Throwable
     */
    protected function validateDeletableComment(int $postId, int $commentId, int $authenticatedUserId): void
    {
        $this->findOrFail(Post::class, $postId);
        /** @var PostComment $comment */
        $comment = $this->findOrFail(PostComment::class, $commentId);

        if ($comment->post_id != $postId) {
            throw (new ModelNotFoundException())->setModel(PostComment::class, [$commentId]);
        }

        throw_if(
            $comment->user_id != $authenticatedUserId,
            BusinessException::class,
            __('business.post.comment_access_denied'),
            ExceptionCode::POST_COMMENT_ACCESS_DENIED,
            Response::HTTP_FORBIDDEN
        );
    }
}
