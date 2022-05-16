<?php

namespace App\Modules\Feed\SearchUser;

use Core\Criteria\Criteria;
use Illuminate\Database\Query\Builder;

class SearchUserCriteria extends Criteria
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
        $query->whereHas('profile', function ($query) use ($value) {
            $query->where('name', 'like', "%$value%")
                ->orWhere('nickname', 'like', "%$value%");

        });
    }
}
