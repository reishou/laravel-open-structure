<?php

namespace App\Modules\Post\GetPostComments;

use Core\Criteria\Criteria;

class GetPostCommentsCriteria extends Criteria
{
    protected array $criteria = [
        'post_id',
    ];
}
