<?php

namespace System;

use Exception;

abstract class LogError {

    /**
     * @var string|null $logFile
     */
    private static string $logFile;

    /**
     * boot
     * 
     * @param string $logFile
     * @return void
     */
    static public function boot(string $logFile): void
    {
        self::$logFile = $logFile;
        self::registerHandlers();
    }

    /**
     * trata todas as exceções nao capturadas
     */
    static public function exceptionHandler($exception): void
    {
        
        $message = date('Y-m-d H:i:s') . " - Exception: " . $exception->getMessage() . "\n";
        $message .= "File: " . $exception->getFile() . " on line " . $exception->getLine() . "\n";
        $message .= "Trace: " . $exception->getTraceAsString() . "\n";
        $message .= "---------------------------------------------------------------------------------\n\n";

        // Logar a mensagem em um arquivo
        error_log($message, 3, self::$logFile);
        require __DIR__ ."/pages/500.php";
    }

    /**
     * Função para tratar todos os erros não capturados
     * 
     * @param string $errno
     * @param string $errstr
     * @param string $errfile
     * @param string $errline
     * 
     * @return boolean
     */
    static public function errorHandler(string $errno,string $errstr,string $errfile,string $errline): bool
    {
        // Formatar a mensagem de erro
        $message = date('Y-m-d H:i:s') . " - Error [$errno]: $errstr\n";
        $message .= "File: $errfile on line $errline\n";
        $message .= "---------------------------------------------------------------------------------\n\n";

        // Logar a mensagem em um arquivo
        error_log($message, 3, self::$logFile);
        require __DIR__ ."/pages/500.php";

        /* Não execute o manipulador interno do PHP */
        return true;
    }

    /**
     * Função para tratar shutdown errors
     * 
     * @return void
     */
    static public function shutdownHandler(): void
    {
        $error = error_get_last();
        if ($error !== NULL) {
            $message = date('Y-m-d H:i:s') . " - Fatal Error: " . $error['message'] . "\n";
            $message .= "File: " . $error['file'] . " on line " . $error['line'] . "\n";
            $message .= "---------------------------------------------------------------------------------\n\n";

            // Logar a mensagem em um arquivo
            error_log($message, 3, self::$logFile);
            require __DIR__ ."/pages/500.php";
        }
    }

    /**
     * Configurar os manipuladores
     * 
     * @return void
     */
    static private function registerHandlers(): void
    {
        set_exception_handler([self::class, 'exceptionHandler']);
        set_error_handler([self::class, 'errorHandler']);
        register_shutdown_function([self::class, 'shutdownHandler']);
    }
}
