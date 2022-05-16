<?php

namespace App\Modules\Feed\SearchImage;

use App\Models\Post;
use App\Models\PostImage;
use Core\Domains\BaseJob;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SearchImageJob extends BaseJob
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
        $query = PostImage::query();
        (new SearchImageCriteria($this->criteria))->apply($query);

        if ($this->with) {
            $query->with($this->with);
        }

        $query->orderByDesc('id');

        return $query->paginate($this->limit);
    }
}
