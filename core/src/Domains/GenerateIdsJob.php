<?php

namespace Core\Domains;

class GenerateIdsJob extends BaseJob
{
    /**
     * @param  string  $class
     * @param  int  $count
     */
    public function __construct(private string $class, private int $count)
    {
    }

    /**
     * @return mixed
     */
    public function handle(): array
    {
        return call_user_func([$this->class, 'generateIds'], $this->count);
    }
}
