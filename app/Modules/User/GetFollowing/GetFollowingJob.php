<?php

namespace App\Modules\User\GetFollowing;

use App\Enums\RelationMap;
use App\Models\Follow;
use Core\Domains\BaseJob;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetFollowingJob extends BaseJob
{
    /**
     * @param  int  $userId
     * @param  int  $limit
     * @param  array  $with
     */
    public function __construct(private int $userId, private int $limit, private array $with = [])
    {
    }

    /**
     * @return LengthAwarePaginator
     */
    public function handle(): LengthAwarePaginator
    {
        $query = Follow::query()
            ->where('user_id', $this->userId)
            ->whereHasMorph('followable', RelationMap::USER);

        if ($this->with) {
            $query->with($this->with);
        }

        $query->orderByDesc('id');

        return $query->paginate($this->limit);
    }
}
