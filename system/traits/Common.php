<?php

declare(strict_types=1);

namespace System\traits;

trait Common
{
    /***
     * @return array
     */
    protected static function getDefaultValueByType($param)
    {
        if ($param === 'string') {
            return "";
        }

        if (in_array($param, ['int', 'float'])) {
            return 0;
        }

        return false;
    }
}
