<?php

declare(strict_types=1);

namespace System;

use PDO;

class Conexao {
    private static $instancia;
    private $conexao;

    private function __construct() {
        $this->conexao = new PDO('mysql:host=mysql;dbname=mysql', 'admin', '12345678');
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function conn() {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }

        return self::$instancia->con();
    }

    public function con() {
        return $this->conexao;
    }
}