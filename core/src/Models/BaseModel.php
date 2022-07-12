<?php

namespace Core\Models;

use Core\Utils\UniqueIdentity;
use DateTimeInterface;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @method static Builder query()
 * @mixin Eloquent
 */
abstract class BaseModel extends Model
{
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            /** @var self $model */
            if ($model->getIncrementing() || !empty($model->{$model->getKeyName()})) {
                return;
            }

            $model->{$model->getKeyName()} = $model->generateIds()[0];
        });
    }

    /**
     * @param  int  $count
     * @return array
     */
    protected function generateIds(int $count = 1): array
    {
        $sequences = $this->getNextSequences($count);
        if ($sequences->isEmpty()) {
            $sequences = collect(range(1, $count));
        }

        return $sequences->map(function ($sequence) {
            return UniqueIdentity::id((int) $sequence);
        })
            ->toArray();
    }

    /**
     * @param  int  $count
     * @return Collection
     */
    protected function getNextSequences(int $count = 1): Collection
    {
        if (DB::getDriverName() == 'pgsql') {
            $results = DB::select(
                'select nextval(?) as next_sequence from generate_series(1,?)',
                [DB::getTablePrefix().$this->getTable().'_id_seq', $count]
            );
        } else {
            $start   = DB::select('select count(*) as count from '.DB::getTablePrefix().$this->getTable())[0]->count ?? 0;
            $results = range($start, $start + $count);
        }

        return collect($results)->pluck('next_sequence');
    }

    /**
     * @param  DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format(DATE_ATOM);
    }

    /**
     * @return string
     */
    public static function table(): string
    {
        $string = get_called_class();

        return (new $string())->getTable();
    }
}
