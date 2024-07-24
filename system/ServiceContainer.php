<?php

declare(strict_types=1);

namespace System;


abstract class ServiceContainer
{
    
    use traits\Common;

    /**
     * @var array $services
     */
    private static array $services = [];

    /**
     * @param string $class
     * @return Object
     */
    static public function container(string $class): Object
    {
        if (!in_array($class, self::$services)) {

            //resolve todas as dependencias da classe
            $constructorParams = self::resolveDepedencias($class);

            $reflector = new \ReflectionClass( $class );

            // ira criar uma instancia da classe '$class' atraves da classe ReflectionClass, o metodo 'newInstanceArgs' invoca o construtor da classe que se deseja criar a instancia
            $instance = $reflector->newInstanceArgs($constructorParams);
            
            self::$services[$class] = $instance;
        }

        return self::$services[$class];
    }

    /**
     * @param string $class
     * @param array $params
     *
     * @return array
     */
    static private function resolveDepedencias(string $class, array &$params = []): array
    {
        $constructorClass = new \ReflectionMethod($class, '__construct');

        foreach ($constructorClass->getParameters() as $key => $param) {
            
            $typeClass = (string) $param->getType(); // Obter o tipo do parâmetro

            if ($typeClass && class_exists($typeClass)) {

                // Se o tipo da classe existir, resolva suas dependências recursivamente
                $params = self::resolveDepedencias( $typeClass, $params );

                // Instancie a classe e adicione ao array de parâmetros
                $reflector = new \ReflectionClass( $typeClass );

                // Cria uma nova instância da classe MinhaClasse e passa os parâmetros para o construtor
                $instance = $reflector->newInstanceArgs($params);

                array_push($params, $instance);
            } else {
                // Se não houver tipo de classe definido ou a classe não existir, apenas adicione o parâmetro ao array
                $param = self::castVar($param);

                echo gettype($param);

                array_push($params, $param);
            }
        }

        return $params;
    }
}
