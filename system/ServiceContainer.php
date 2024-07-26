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
    static public function container(string $class): object
    {
        if (!in_array($class, self::$services)) {

            //resolve todas as dependencias da classe
            $constructorParams = self::resolveDepedenciasConstructor($class);

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
    static private function resolveDepedenciasConstructor(string $class, array &$params = []): array
    {
        $constructorClass = new \ReflectionMethod($class, '__construct');

        foreach ($constructorClass->getParameters() as $key => $param) {
            
            $typeClass = (string) $param->getType(); // Obter o tipo do parâmetro

            if ($typeClass && class_exists($typeClass)) {

                $params = self::resolveDepedenciasConstructor( $typeClass, $params );
                $reflector = new \ReflectionClass( $typeClass );
                $instance = $reflector->newInstanceArgs($params);

                $params[] = $instance;
            } else {

                if ($param->isDefaultValueAvailable()) {

                    $params[] = $param->getDefaultValue();
                } else {
                    
                    $params[] = self::getDefaultValueByType($param->getType());
                }
            }
        }

        return $params;
    }

    /**
     * @param object $object
     * @param array $params
     *
     * @return array
     */
    static public function resolveDepedenciasMethod(object $object, string $method, array &$params = []): array
    {
        $methodClass = new \ReflectionMethod($object, $method);

        foreach ($methodClass->getParameters() as $key => $param) {
            
            $typeClass = (string) $param->getType(); // Obter o tipo do parâmetro

            if ($typeClass && class_exists($typeClass)) {

                $constructorParams = [];
                $constructorParams = self::resolveDepedenciasConstructor( $typeClass, $constructorParams );
                $reflector = new \ReflectionClass( $typeClass );
                $instance = $reflector->newInstanceArgs($constructorParams);

                $params[] = $instance;

            } else {

                if ($param->isDefaultValueAvailable()) {

                    $params[] = $param->getDefaultValue();
                } else {

                    $params[] = self::getDefaultValueByType($param->getType());
                }
            }
        }

        return $params;
    }
}
