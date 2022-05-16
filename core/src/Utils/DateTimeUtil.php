<?php

namespace Core\Utils;

use Exception;
use Illuminate\Support\Carbon;

trait DateTimeUtil
{
    /**
     * @param  string  $format
     * @param $time
     * @param  null  $timezone
     * @return \Carbon\Carbon|false|null
     */
    public function createFromFormat(string $format, $time, $timezone = null): bool|\Carbon\Carbon|null
    {
        try {
            return Carbon::createFromFormat($format, $time, $timezone);
        } catch (Exception) {
            return null;
        }
    }
}
