<?php

namespace Core\Domains;

use Core\Exceptions\BaseException;
use Core\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use ReflectionClass;
use ReflectionException;
use Throwable;

class FindOrFailJob extends BaseJob
{
    private bool $single;

    /**
     * @param  string  $class
     * @param  int|array  $ids
     * @param  array  $with
     */
    public function __construct(private string $class, private int|array $ids, private array $with = [])
    {
        $this->single = is_int($this->ids);
    }

    /**
     * @return mixed
     * @throws ReflectionException
     * @throws Throwable
     */
    public function handle(): mixed
    {
        $reflection = new ReflectionClass($this->class);
        /** @var BaseModel $instance */
        $instance = $reflection->newInstance();

        throw_if(
            !$instance instanceof Model,
            BaseException::class,
            __('core.class_must_be_model')
        );

        $this->ids = Arr::wrap($this->ids);
        $query     = $instance->query();

        $query->whereIn($instance->getKeyName(), $this->ids);

        if ($this->with) {
            $query->with($this->with);
        }

        $collection = $query->get();
        if ($collection->isEmpty()) {
            throw (new ModelNotFoundException())->setModel($this->class, $this->ids);
        }

        $diff = collect($this->ids)->diff($collection->pluck('id'));
        if ($diff->isNotEmpty()) {
            throw (new ModelNotFoundException())->setModel($this->class, $diff->toArray());
        }

        if ($this->single) {
            return $collection->first();
        }

        return $collection;
    }
}
