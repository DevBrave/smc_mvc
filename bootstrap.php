<?php

use Core\App;
use Core\Container;
use Core\Database;

$container = new Container();
$container->bind('Core\Database', function () {
    $config = require(base_path('config.php'));
    $dbConfig = $config['database'];

    $username = $dbConfig['username'] ?? 'root';
    $password = $dbConfig['password'] ?? '';

    unset($dbConfig['username'], $dbConfig['password']);

    return new Database($dbConfig, $username, $password);
});

App::setContainer($container);
