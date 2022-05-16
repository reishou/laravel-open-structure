<?php

namespace App\Modules\Feed\GetFeeds;

use Core\Criteria\Criteria;

class GetFeedsCriteria extends Criteria
{
    protected array $criteria = [
        'user_id',
    ];
}
