<?php

require __DIR__ .'/vendor/autoload.php';

use App\Controller\HomeController;
use App\Controller\TestController;

/*--------------------------------------------
 * Routers
 * -------------------------------------------
 *  Insert the character "/" in start router
 *  "/namerouter/paramrouter"
 */
$routes = [
    '' => [HomeController::class, 'index'],
    '/tipos' => [TestController::class, 'index']
];

return $routes;