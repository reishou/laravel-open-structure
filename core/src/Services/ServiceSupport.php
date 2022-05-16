<?php

namespace Core\Services;

use Core\Domains\CheckTempFileExistsJob;
use Core\Domains\FindOrFailJob;
use Core\Domains\GenerateIdsJob;
use Core\Domains\MoveFromTempToDestinationJob;
use Core\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

trait ServiceSupport
{
    /**
     * @param  Request  $request
     * @return int
     */
    protected function getLimit(Request $request): int
    {
        $limit = (int) $request->query('limit') ?: config('parameter.default_limit');

        return min($limit, config('parameter.max_limit'));
    }

    /**
     * @param  string  $class
     * @param  int|array  $ids
     * @param  array  $with
     * @return BaseModel|Collection
     */
    protected function findOrFail(string $class, int|array $ids, array $with = []): BaseModel|Collection
    {
        return $this->run(FindOrFailJob::class, compact('class', 'ids', 'with'));
    }

    /**
     * @param  string  $class
     * @param  int  $count
     * @return array
     */
    protected function generateIds(string $class, int $count = 1): array
    {
        return $this->run(GenerateIdsJob::class, compact('class', 'count'));
    }

    /**
     * @param  array  $filenames
     * @param  string  $directoryType
     * @param  int  $userId
     * @return void
     */
    protected function checkTempFileExists(array $filenames, string $directoryType, int $userId): void
    {
        $this->run(CheckTempFileExistsJob::class, [
            'type'      => $directoryType,
            'userId'    => $userId,
            'filenames' => $filenames,
        ]);
    }

    /**
     * @param  array  $filenames
     * @param  string  $directoryType
     * @param  int  $userId
     * @param  int  $instanceId
     * @return void
     */
    protected function moveFromTempToDestination(
        array $filenames,
        string $directoryType,
        int $userId,
        int $instanceId = 0
    ): void {
        $this->run(MoveFromTempToDestinationJob::class, [
            'type'       => $directoryType,
            'userId'     => $userId,
            'filenames'  => $filenames,
            'instanceId' => $instanceId,
        ]);
    }
}
