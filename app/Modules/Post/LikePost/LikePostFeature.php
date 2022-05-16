<?php

namespace App\Modules\Post\LikePost;

use App\Enums\RelationMap;
use App\Models\Post;
use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class LikePostFeature extends BaseFeatures
{
    /**
     * @param  int  $id
     */
    public function __construct(private int $id)
    {
    }

    /**
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function handle(): JsonResponse
    {
        $this->validateLikeablePost($this->id);
        $this->likePost($this->id, (int) Auth::id());

        return $this->success(true);
    }

    /**
     * @param  int  $id
     * @param  int  $authenticatedUserId
     * @return void
     * @throws UnknownProperties
     */
    protected function likePost(int $id, int $authenticatedUserId): void
    {
        $this->run(LikePostJob::class, [
            'dto' => new LikePostDto(
                userId: $authenticatedUserId,
                likeableId: $id,
                likeableType: RelationMap::POST
            )
        ]);
    }

    /**
     * @param  int  $id
     * @return void
     */
    protected function validateLikeablePost(int $id): void
    {
        /** @var Post $post */
        $this->findOrFail(Post::class, $id);
    }
}
