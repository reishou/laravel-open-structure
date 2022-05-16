<?php

namespace Core\Utils;

use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class UniqueIdentity
{
    const OUR_EPOCH = 1632960000000; // 2021/09/30 00:00:00

    /**
     * @param  int  $nextSequenceId
     * @param  int  $shardId
     * @return int
     */
    public static function id(int $nextSequenceId, int $shardId = 1): int
    {
        $now   = Carbon::now()->valueOf();
        $time  = (int) ($now - self::OUR_EPOCH);
        $seqId = $nextSequenceId % 1024;

        // max 2^5 = 32 shard id
        $id = $time << 15;
        $id = $id | ($shardId << 10);

        return $id | ($seqId);
    }

    /**
     * @param  int  $id
     * @return array
     */
    #[ArrayShape(['time' => "int", 'shard_id' => "int", 'sequence_id' => "int"])]
    public static function decompose(int $id): array
    {
        $time    = ($id >> 15) & 0x1FFFFFFFFFF;
        $shardId = ($id >> 10) & 0x1F;
        $seqId   = ($id >> 0) & 0x3FF;

        return [
            'time'        => $time,
            'shard_id'    => $shardId,
            'sequence_id' => $seqId,
        ];
    }
}
