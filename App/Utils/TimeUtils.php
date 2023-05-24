<?php
namespace App\Utils;

class TimeUtils
{
    public static function parseTimeArgument($arg)
    {
        $modifier = substr($arg, 0, 1);
        $value = substr($arg, 1, -1);
        $unit = substr($arg, -1);

        if ($modifier === '+') {
            return time() + self::parseTimeUnit($value, $unit);
        } else {
            throw new \InvalidArgumentException('Invalid time argument');
        }
    }

    private static function parseTimeUnit($value, $unit)
    {
        $amount = intval($value);

        switch ($unit) {
            case 's':
                return $amount;
            case 'm':
                return $amount * 60;
            case 'h':
                return $amount * 60 * 60;
            default:
                throw new \InvalidArgumentException('Invalid time unit');
        }
    }
}