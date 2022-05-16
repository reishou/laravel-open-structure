<?php

namespace Core\Enums;

class FileDirectoryType extends Enum
{
    /**
     * @param  string  $type
     * @param  int  $userId
     * @return string
     */
    public static function getTempDirectory(string $type, int $userId): string
    {
        return "temp/$userId/$type";
    }

    /**
     * @param  string  $type
     * @param  int  $userId
     * @param  int  $instanceId
     * @return string
     */
    public static function getStorageDirectory(string $type, int $userId, int $instanceId = 0): string
    {
        if (!$instanceId) {
            return "$type/$userId";
        }

        return "$type/$userId/$instanceId";
    }
}
