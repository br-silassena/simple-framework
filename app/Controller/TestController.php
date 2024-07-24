<?php

declare (strict_types=1);

namespace App\Controller;

use System\BaseController;

class TestController extends BaseController
{
    public function __construct(string $nome, int $idade, float $salario)
    {
        echo "nome é " . gettype($nome). " idade é " . gettype($idade). " salario é " . gettype($salario);
    }

    public function index() {
        return $this->view('welcome');
    }
}
