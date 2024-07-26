<?php

declare(strict_types=1);

namespace System;

abstract class Session
{ 
    final public static function set(string $name, mixed $value):void
    {
        $_SESSION[$name] = $value;
    }

    final public static function get(string $name): mixed
    {
        return $_SESSION[$name] ?? '';
    }

    final public static function all(): mixed
    {
        return $_SESSION;
    }

    final public static function destroy(string $name = ""): bool
    {
        if ($name === "") {
            session_destroy();
            return true;
        }
        
        if (isset( $_SESSION[$name] )) {
            unset($_SESSION[$name]);
        }
    }
}
