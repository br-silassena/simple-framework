<?php

declare(strict_types=1);

namespace System\traits;

trait Common
{
    /***
     * @return mixed
     */
    protected static function getDefaultValueByType($param): mixed
    {
        if ($param === 'string') {
            return "";
        }

        if (in_array($param, ['int', 'float'])) {
            return 0;
        }

        return false;
    }

    /***
     * @return array
     */
    protected static function typeValue(mixed $value): mixed
    {
        if (is_numeric($value)) {
            // Check if the value is an integer or a float
            if (ctype_digit((string) $value)) {
                return (int) $value;
            } else {
                return (float) $value;
            }
        } elseif (is_bool($value)) {
            return (bool) $value;
        } else {
            // Default to string for other types
            return (string) $value;
        }
    }
}
