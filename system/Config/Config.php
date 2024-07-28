<?php

namespace System\Config;

abstract class Config {

    /**
     * @var static array $config
     */
    static private array $config = [

        'url_base' => 'http://localhost:8080',

        'database' => [

            'mysql' => [
                'host' => 'mysql',
                'banco' =>'appdados',
                'port' =>'3306',
                'username' => 'appdados',
                'password' => '12345678'
            ]
        ]
    ];
    
    /**
     * rebece o caminho no array separado por pontos = 'database.mysql.host'
     * 
     * @param string $uri
     * 
     * @return string
     */
    static public function loadConfig(string $uri): string
    {
        $keys = explode('.', $uri);
        $value = self::$config;

        foreach ($keys as $key) {
            if (!isset($value[$key])) {
                return null;
            }
            $value = $value[$key];
        }

        return $value;
    }
}
