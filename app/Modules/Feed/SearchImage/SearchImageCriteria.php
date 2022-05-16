<?php

namespace App\Modules\Feed\SearchImage;

use Core\Criteria\Criteria;
use Illuminate\Database\Query\Builder;

class SearchImageCriteria extends Criteria
{
    protected array $criteria = [
        'keyword'
    ];

    /**
     * @param  \Illuminate\Database\Eloquent\Builder|Builder  $query
     * @param  mixed  $value
     * @return void
     */
    public function criteriaKeyword(\Illuminate\Database\Eloquent\Builder|Builder $query, mixed $value): void
    {
        $value = (string) $value;
        $query->whereHas('post', function ($query) use ($value) {
            $query->where('content', 'like', "%$value%");
        });
    }
}
