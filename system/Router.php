<?php

declare(strict_types=1);

namespace System;

use System\ServiceContainer;
#use System\ServiceContainer as SystemServiceContainer;

abstract class Router
{
    use traits\Common;

    /**
     * 
     * @return void
     */
    final public static function getRouter(array $routes): void
    {
        //pega a uri no browser e descarta as querys params quando a requisição for do tipo Get
        $currentUri = explode('?', $_SERVER['REQUEST_URI'])[0];
        
        $browserRouter = explode("/", $currentUri);
        $browserRouter = array_filter($browserRouter, fn ($item) => $item !== "");

        #percorre o array de rotas registrado no sistema
        foreach ($routes as $routerKey => $routerValue) {

            $fileRouter =  explode("/", $routerKey);
            $fileRouter = array_filter($fileRouter, fn ($item) => $item !== "");
            $params = [];

            #verificando se a rota atual tem o mesmo tamanho da rota encontrada no loop do array das rotas do sistema
            if (count($browserRouter) === count($fileRouter)) {

                foreach ($fileRouter as $keyUriFile => $valeuUriFile) {

                    if (strpos($valeuUriFile, '{') !== false) {
                        $fileRouter[$keyUriFile] = $browserRouter[$keyUriFile];
                        $params[] = self::typeValue($browserRouter[$keyUriFile]);
                    }

                    if ($fileRouter[$keyUriFile] !== $browserRouter[$keyUriFile]) {
                        break;
                    }
                }

                #verificando se a rota do browser é a mesma rota registrada no sistema
                if ($fileRouter === $browserRouter) {

                    $controler = $routerValue[0];
                    $method = $routerValue[1];
                    $object = ServiceContainer::container($controler);
                    
                    #falta implementar a injeção de dependencias pelo metodo
                   // $params = ServiceContainer::resolveDepedenciasMethod($object, $method, $params);
                    
                    echo $object->$method(...$params);
                    return;
                }
            }
        }

        require __DIR__ ."/pages/404.php";
    }
}
