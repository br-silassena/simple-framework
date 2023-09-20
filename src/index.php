<?php

require __DIR__ .'/vendor/autoload.php';

use App\Controller\HomeController;
use System\Router;

/**
 * 
 * Routers
 * 
 */
$route = [
    '' => [HomeController::class, 'index']
];

Router::getRouter($route);
