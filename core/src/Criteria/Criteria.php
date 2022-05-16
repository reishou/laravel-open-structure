<?php

namespace Core\Criteria;

use Closure;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

abstract class Criteria
{
    protected string $table;
    protected array  $param        = [];
    protected array  $original     = [];
    protected array  $criteria     = [];
    protected string $prefixMethod = 'criteria';
    protected array  $dateTypes    = [
        'bool',
        'int',
        'float',
        'string',
        'array',
        'object',
    ];
    protected array $operations = [
        'like',
        'ilike',
    ];

    /**
     * Criteria constructor.
     *
     * @param  array  $param
     */
    public function __construct(array $param)
    {
        $this->setOriginal($param);
        $this->setParam($param);
    }

    /**
     * @param  array  $param
     */
    public function setOriginal(array $param): void
    {
        $this->original = $param;
    }

    /**
     * @param  array  $param
     */
    public function setParam(array $param): void
    {
        $this->param = collect($param)
            ->filter($this->filterParam())
            ->transform($this->transformParam())
            ->toArray();
    }

    /**
     * @return Closure
     */
    protected function transformParam(): Closure
    {
        return function ($value, $key) {
            return $this->castDataType($value, $key);
        };
    }

    /**
     * @param $value
     * @param $key
     * @return mixed
     */
    protected function castDataType($value, $key): mixed
    {
        if (!key_exists($key, $this->criteria) || !in_array($this->criteria[$key], $this->dateTypes)) {
            return $value;
        }

        if (is_iterable($value)) {
            foreach ($value as $index => $element) {
                settype($value[$index], $this->criteria[$key]);
            }
        } else {
            settype($value, $this->criteria[$key]);
        }

        return $value;
    }

    /**
     * @return Closure
     */
    protected function filterParam(): Closure
    {
        return function ($value, $key) {
            if (is_object($value)) {
                return false;
            }

            if (!in_array($key, $this->criteria) && !key_exists($key, $this->criteria)) {
                return false;
            }

            if (is_array($value)) {
                $value = collect($value)->filter(
                    function ($value) {
                        return $value !== null;
                    }
                )
                    ->toArray();
            }

            return is_array($value) ? !empty($value) : $value !== null;
        };
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder|Builder  $query
     */
    public function apply(\Illuminate\Database\Eloquent\Builder|Builder $query): void
    {
        $this->setTable($query);
        foreach ($this->param as $key => $value) {
            if ($this->customMethod($query, $key, $value)) {
                continue;
            }
            $this->basicCriteria($query, $key, $value);
        }
    }

    /**
     * @param $query
     */
    protected function setTable($query): void
    {
        $this->table = '';
        if ($query instanceof \Illuminate\Database\Eloquent\Builder) {
            $this->table .= $query->getModel()->getTable();
        } elseif ($query instanceof Builder) {
            $this->table .= $query->from;
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder|Builder  $query
     * @param $key
     * @param $value
     * @return bool
     */
    protected function customMethod(\Illuminate\Database\Eloquent\Builder|Builder $query, $key, $value): bool
    {
        $method = $this->prefixMethod.Str::studly($key);
        if (method_exists($this, $method)) {
            $this->{$method}($query, $value);

            return true;
        }

        return false;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder|Builder  $query
     * @param $key
     * @param $value
     */
    protected function basicCriteria(\Illuminate\Database\Eloquent\Builder|Builder $query, $key, $value): void
    {
        $criteria = $this->getCriteria();

        if (key_exists($key, $criteria)) {
            $operation = Str::lower($criteria[$key]);
            if (in_array($operation, $this->operations)) {
                $query->where($this->getTable().'.'.$key, $operation, "%$value%");

                return;
            }
        }

        if (in_array($key, $criteria) || key_exists($key, $criteria)) {
            $value = Arr::wrap($value);
            $query->whereIn($this->getTable().'.'.$key, $value);
        }
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @return array
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }

    /**
     * @param  Closure  $callback
     * @param  string  $format
     * @param  string  $value
     * @param  string|null  $timezone
     * @return mixed
     */
    protected function parseDate(Closure $callback, string $format, string $value, string $timezone = null): mixed
    {
        $timezone = $timezone ?: config('app.client_timezone');

        try {
            $date = Carbon::createFromFormat($format, $value, $timezone);
        } catch (Exception) {
            $date = null;
        }

        return $date ? $callback($date) : $date;
    }

    /**
     * @param  string  $value
     * @param  string  $format
     * @param  string|null  $timezone
     * @return mixed
     */
    protected function parseStartOfDate(string $value, string $format, string $timezone = null): mixed
    {
        return $this->parseDate(function (Carbon $date) {
            return $date->startOfDay()
                ->setTimezone(config('app.timezone'));
        }, $format, $value, $timezone);
    }

    /**
     * @param  string  $value
     * @param  string  $format
     * @param  string|null  $timezone
     * @return mixed
     */
    protected function parseEndOfDate(string $value, string $format, string $timezone = null): mixed
    {
        return $this->parseDate(function (Carbon $date) {
            return $date->endOfDay()
                ->setTimezone(config('app.timezone'));
        }, $format, $value, $timezone);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder|Builder  $query
     * @param  string  $field
     * @param $operator
     * @param $time
     */
    protected function queryCriteriaDate(
        \Illuminate\Database\Eloquent\Builder|Builder $query,
        string $field,
        $operator,
        $time
    ): void {
        if ($time) {
            $query->where("$this->table.$field", $operator, $time);
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder|Builder  $query
     * @param  string  $field
     * @param  string  $value
     * @param  string  $format
     * @param  string|null  $timezone
     */
    protected function queryDateFrom(
        \Illuminate\Database\Eloquent\Builder|Builder $query,
        string $field,
        string $value,
        string $format = 'Y-m-d',
        string $timezone = null
    ): void {
        $time = $this->parseStartOfDate($value, $format, $timezone);
        $this->queryCriteriaDate($query, $field, '>=', $time);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder|Builder  $query
     * @param  string  $field
     * @param  string  $value
     * @param  string  $format
     * @param  string|null  $timezone
     */
    protected function queryDateTo(
        \Illuminate\Database\Eloquent\Builder|Builder $query,
        string $field,
        string $value,
        string $format = 'Y-m-d',
        string $timezone = null
    ): void {
        $time = $this->parseEndOfDate($value, $format, $timezone);
        $this->queryCriteriaDate($query, $field, '<=', $time);
    }
}