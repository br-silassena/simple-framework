<?php

declare(strict_types=1);

namespace System\traits;

trait Common
{
    /***
     * @return array
     */
    protected static function castVar(mixed $param)
    {
        $response = null;

        switch ($param) {
            case 'int':

                $response = (string) $param;

                if (is_numeric($param)) {
                    $response = (int) $param;
                }

                break;
            case 'string':
                $response = (string) $param;
                break;
            case 'float':

                $response = (string) $param;

                if (is_numeric($param)) {
                    $response = (float) $param;
                }

                break;
            case 'boolean':
                $response = (bool) $param;
                break;
            case 'Array':
                $response = (array) $param;
                break;
            case 'Object':
                $response = (object) $param;
                break;
            default:
                $response = (string) $param;
                break;
        }
        
        return $response;
    }
}
