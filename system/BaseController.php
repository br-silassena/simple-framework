<?php

declare(strict_types=1);

namespace System;

use System\traits\Request;

class BaseController
{
    use Request;
    
    /**
     * @param string view
     * @param array|null $params
     * 
     * @return void
     */
    protected function view(string $view, array $params = []): void
    {
        //criando variavel dinamicamente
        foreach($params as $key => $value)  {
            ${$key} = $value;
        }
        require __DIR__ . "/../app/{$view}.php";
    }
}
