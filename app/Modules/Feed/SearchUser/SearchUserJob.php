<?php

namespace App\Modules\Feed\SearchUser;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Core\Domains\BaseJob;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SearchUserJob extends BaseJob
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
        $query = User::query();
        (new SearchUserCriteria($this->criteria))->apply($query);

        if ($this->with) {
            $query->with($this->with);
        }

        $query->orderByDesc('id');

        return $query->paginate($this->limit);
    }
}
