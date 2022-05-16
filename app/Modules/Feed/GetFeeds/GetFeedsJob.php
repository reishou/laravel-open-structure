<?php

namespace App\Modules\Feed\GetFeeds;

use App\Models\Post;
use Core\Domains\BaseJob;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetFeedsJob extends BaseJob
{
    /**
     * @param  array  $criteria
     * @param  int  $limit
     * @param  array  $with
     */
    public function __construct(private array $criteria, private int $limit, private array $with = [])
    {
    }

    /**
     * @return LengthAwarePaginator
     */
    public function handle(): LengthAwarePaginator
    {
        $query = Post::query();
        (new GetFeedsCriteria($this->criteria))->apply($query);

        if ($this->with) {
            $query->with($this->with);
        }

        $query->orderByDesc('id');

        return $query->paginate($this->limit);
    }
}
