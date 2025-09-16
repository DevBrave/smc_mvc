<?php

use Core\App;
use Core\Database;
use Core\Router;

session_start();
define("BASE_PATH", $_SERVER['DOCUMENT_ROOT']);
require('../helpers/functions.php');


spl_autoload_register(function ($class){
    // Define namespace to directory mappings
    $namespaceMap = [
        'Api\\' => 'app/Controllers/Api/',
        'Admin\\' => 'app/Controllers/Admin/',
        'Core\\' => 'Core/',
        'app\\' => '',
    ];
    
    // Check each namespace mapping
    foreach ($namespaceMap as $namespace => $directory) {
        if (strpos($class, $namespace) === 0) {
            $className = str_replace($namespace, '', $class);
            $file = base_path($directory . $className . '.php');
            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }
    
    // Fallback: try as regular controller
    $file = base_path('app/Controllers/' . $class . '.php');
    if (file_exists($file)) {
        require $file;
        return;
    }
    
    // Final fallback: original behavior
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $fallbackFile = base_path($classPath . '.php');
    if (file_exists($fallbackFile)) {
        require $fallbackFile;
    }
});

$router = new Router();


require(base_path('routes/routes.php'));
require(base_path('routes/api.php'));
//dd($router->all_routes());

require(base_path('bootstrap.php'));



$current_url = $_SERVER['REQUEST_URI'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
$router->routes($current_url,$method);



