<?php

namespace Core\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Spatie\DataTransferObject\DataTransferObject;

abstract class Dto extends DataTransferObject implements Arrayable
{
    /**
     * @param  array  $includeKeys
     * @return array
     */
    public function updatable(array $includeKeys = []): array
    {
        return Arr::where($this->toArray(), function ($value, $key) use ($includeKeys) {
            return in_array($key, $includeKeys) || !empty($value);
        });
    }
}
