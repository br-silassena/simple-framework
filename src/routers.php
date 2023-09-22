<?php

require __DIR__ .'/vendor/autoload.php';

use App\Controller\HomeController;

/*--------------------------------------------
 * Routers
 * -------------------------------------------
 *  Insert the character "/" in start router
 *  "/namerouter/paramrouter"
 */
$routes = [
    '' => [HomeController::class, 'index'],
    '/destroy' => [HomeController::class, 'destroy'],
    '/get' => [HomeController::class, 'get']
];

return $routes;