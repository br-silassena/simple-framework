<?php
session_start();
require __DIR__ .'/vendor/autoload.php';

use System\Router;

/*---------------
 * Routers
 *---------------
 */
$routes = require __DIR__ .'/routers.php';

Router::getRouter($routes);

