<?php

declare (strict_types=1);

namespace App\Controller;

use System\Controller;

class HomeController extends Controller{

    public function __construct() {
    }

    public function index()
    {
        return $this->view('welcome', ['nome' => 'Silas Sena']);
    }
}