<?php

use Core\App;
use Core\Database;
use Core\Router;

session_start();
define("BASE_PATH", $_SERVER['DOCUMENT_ROOT']);
require('../helpers/functions.php');



spl_autoload_register(function ($class){

    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require base_path($class . '.php');

});

$router = new Router();


require(base_path('routes/routes.php'));
require(base_path('bootstrap.php'));



$current_url = $_SERVER['REQUEST_URI'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
$router->routes($current_url,$method);



