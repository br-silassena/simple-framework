<?php
session_start();
require __DIR__ .'/vendor/autoload.php';

use System\Router;

/**--------------
 * Errors Logs
 * -------------
 */
System\LogError::boot(__DIR__ .'/errors.txt');


/*---------------
 * Routers
 *---------------
 */
$routes = require __DIR__ .'/routers.php';

Router::getRouter($routes);
