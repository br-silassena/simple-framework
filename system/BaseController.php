<?php

declare(strict_types=1);

namespace System;

use System\traits\Request;
use System\Config\Config;

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

    /**
     * @param string $url
     * 
     * @return string
     */
    public function baseUrl(string $url = ""): string
    {
        return Config::loadConfig('url_base') . $url;
    }

    /**
     * @param string $string
     * 
     * @return string
     */
    public function redirect(string $router) {
        
        $fullRouter = $this->baseUrl($router);
        header("Location:  $fullRouter");
    }

    /**
     * @param string $string
     * 
     * @return string
     */
    public function slug(string $string): string 
    {
        // Converter para minúsculas
        $string = strtolower($string);
    
        // Substituir caracteres especiais
        $unwanted_array = [
            'á'=>'a','à'=>'a','ã'=>'a','â'=>'a','ä'=>'a',
            'é'=>'e','è'=>'e','ê'=>'e','ë'=>'e',
            'í'=>'i','ì'=>'i','î'=>'i','ï'=>'i',
            'ó'=>'o','ò'=>'o','õ'=>'o','ô'=>'o','ö'=>'o',
            'ú'=>'u','ù'=>'u','û'=>'u','ü'=>'u',
            'ç'=>'c',
            'ñ'=>'n'
        ];
        $string = strtr($string, $unwanted_array);
    
        // Substituir qualquer coisa que não seja uma letra, número ou espaço por um espaço
        $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
    
        // Substituir múltiplos espaços ou hifens por um único espaço
        $string = preg_replace('/[\s-]+/', ' ', $string);
    
        // Substituir espaços por hifens
        $string = preg_replace('/\s/', '-', $string);
    
        // Remover hifens no início e no final da string
        $string = trim($string, '-');
    
        return $string;
    }

     /**
     * 
     * @param string $data_original = "2024-04-24 00:00:00";
     *
     * @return string
     */
    public function brData(string $data_original, $withTime = false): string
    {
        $mask = 'd/m/Y';

        $timestamp = strtotime($data_original);

        if ($withTime) {
            $mask = 'd/m/Y H:i:s';
        }

        return date($mask, $timestamp) ?? $data_original;
    }
}
