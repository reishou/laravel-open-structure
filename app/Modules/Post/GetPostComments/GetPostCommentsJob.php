<?php

namespace App\Modules\Post\GetPostComments;

use App\Models\PostComment;
use Core\Domains\BaseJob;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetPostCommentsJob extends BaseJob
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
        $query = PostComment::query();
        (new GetPostCommentsCriteria($this->criteria))->apply($query);

        if ($this->with) {
            $query->with($this->with);
        }

        $query->orderByDesc('id');

        return $query->paginate($this->limit);
    }
}
