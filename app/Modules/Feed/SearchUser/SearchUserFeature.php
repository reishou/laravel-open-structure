<?php

namespace App\Modules\Feed\SearchUser;

use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SearchUserFeature extends BaseFeatures
{
    /**
     * @param  SearchUserRequest  $request
     * @return JsonResponse
     */
    public function handle(SearchUserRequest $request): JsonResponse
    {
        $users = $this->getUsers($request, (int) Auth::id());

        return $this->success(new SearchUserTransformer($users));
    }

    /**
     * @param  SearchUserRequest  $request
     * @param  int  $authenticatedUserId
     * @return mixed
     */
    protected function getUsers(SearchUserRequest $request, int $authenticatedUserId): mixed
    {
        return $this->run(SearchUserJob::class, [
            'criteria' => [
                'keyword' => (string) $request->input('keyword'),
            ],
            'limit'    => $this->getLimit($request),
            'with'     => [
                'profile',
                'followed' => function ($query) use ($authenticatedUserId) {
                    $query->where('user_id', $authenticatedUserId);
                },
            ],
        ]);
    }
}
