<?php

namespace App\Modules\Post\DeletePost;

use App\Enums\ExceptionCode;
use App\Exceptions\BusinessException;
use App\Models\Post;
use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DeletePostFeature extends BaseFeatures
{
    /**
     * @param  int  $id
     */
    public function __construct(private int $id)
    {
    }

    /**
     * @return JsonResponse
     * @throws Throwable
     */
    public function handle(): JsonResponse
    {
        $this->validateDeletablePost($this->id, (int) Auth::id());
        $this->deletePost($this->id);

        return $this->success(true);
    }

    /**
     * @param  int  $id
     * @return void
     */
    protected function deletePost(int $id): void
    {
        $this->run(DeletePostJob::class, ['id' => $id]);
    }

    /**
     * @param  int  $id
     * @param  int  $authenticatedUserId
     * @return void
     * @throws Throwable
     */
    protected function validateDeletablePost(int $id, int $authenticatedUserId): void
    {
        /** @var Post $post */
        $post = $this->findOrFail(Post::class, $id);

        throw_if(
            $post->user_id != $authenticatedUserId,
            BusinessException::class,
            __('business.post.post_access_denied'),
            ExceptionCode::POST_ACCESS_DENIED,
            Response::HTTP_FORBIDDEN
        );
    }
}
