<?php

namespace App\Modules\Post\GetPostDetail;

use App\Models\Post;
use Core\Models\BaseModel;
use Core\Services\BaseFeatures;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetPostDetailFeature extends BaseFeatures
{
    /**
     * @param  int  $id
     */
    public function __construct(private int $id)
    {
    }

    /**
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        $post = $this->getPost($this->id, (int) Auth::id());

        return $this->success(new GetPostDetailTransformer($post));
    }

    /**
     * @param  int  $id
     * @param  int  $authenticatedUserId
     * @return Collection|BaseModel
     */
    protected function getPost(int $id, int $authenticatedUserId): Collection|BaseModel
    {
        return $this->findOrFail(Post::class, $id, [
            'images',
            'user.profile',
            'user.followed',
            'topComments.user.profile',
            'topComments.liked' => function ($query) use ($authenticatedUserId) {
                $query->where('user_id', $authenticatedUserId);
            },
            'likes',
            'comments',
            'liked'             => function ($query) use ($authenticatedUserId) {
                $query->where('user_id', $authenticatedUserId);
            },
        ]);
    }
}
