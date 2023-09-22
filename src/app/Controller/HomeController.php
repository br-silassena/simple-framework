<?php

declare (strict_types=1);

namespace App\Controller;

use System\BaseController;

class HomeController extends BaseController {

    public function __construct() {}

    public function index()
    {
        return $this->view('welcome');
    }
}