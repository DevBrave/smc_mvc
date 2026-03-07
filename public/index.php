<?php


use Core\Router;

const BASE_PATH = __DIR__ . '/../';


// every things run here for the whole server


require(BASE_PATH . '/vendor/autoload.php');  // autoload with composer



session_start();

$config = require(BASE_PATH . 'config.php');
if (isset($config['auto_login']) && $config['auto_login'] === true) {
    if (!isset($_SESSION['user'])) {
        $_SESSION['user'] = 'admin';
    }
}

require(BASE_PATH . 'helpers/functions.php');

$router = new Router();


require(base_path('routes/routes.php'));
require(base_path('routes/api.php'));


require(base_path('bootstrap.php'));



$current_url = $_SERVER['REQUEST_URI'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];


//dd($router->all_routes()); // all the routes we added from the routes and api file

$router->routes($current_url, $method);
