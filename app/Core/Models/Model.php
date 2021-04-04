<?php

namespace App\Core\Models;

use App\Core\Criteria\Criteria;
use DateTimeInterface;

class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format(DATE_ISO8601);
    }

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function applyCriteria(Criteria $criteria): Model
    {
        $criteria->apply($this);

        return $this;
    }
}
