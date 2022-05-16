<?php

namespace App\Modules\Post\UnlikePost;

use App\Enums\RelationMap;
use App\Models\Post;
use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UnlikePostFeature extends BaseFeatures
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
        $this->validateUnlikeablePost($this->id);
        $this->unlikePost($this->id, (int) Auth::id());

        return $this->success(true);
    }

    /**
     * @param  int  $id
     * @param  int  $authenticatedUserId
     * @return void
     * @throws UnknownProperties
     */
    protected function unlikePost(int $id, int $authenticatedUserId): void
    {
        $this->run(UnlikePostJob::class, [
            'dto' => new UnlikePostDto(
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
    protected function validateUnlikeablePost(int $id): void
    {
        /** @var Post $post */
        $this->findOrFail(Post::class, $id);
    }
}
