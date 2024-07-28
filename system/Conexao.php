<?php

declare(strict_types=1);

namespace System;

use System\Config\Config;

use Exception;
use PDO;

class Conexao
{
    private static $instancia;
    private mixed $conexao;
    private string $host;
    private string $banco;
    private string $username;
    private string $password;

    private function __construct()
    {
        $this->host = Config::loadConfig('database.mysql.host');
        $this->banco = Config::loadConfig('database.mysql.banco');
        $this->username = Config::loadConfig('database.mysql.username');
        $this->password = Config::loadConfig('database.mysql.password');

        try {
            $this->conexao = new PDO("mysql:host=$this->host;dbname=$this->banco", $this->username, $this->password);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            $this->conexao = null;
        }
    }

    public static function conn()
    {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }

        return self::$instancia->con();
    }

    public function con()
    {
        return $this->conexao;
    }
}
