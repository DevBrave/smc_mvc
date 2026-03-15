<?php


use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Middleware\GuestMiddleware;

return [
    'database' => [

        'host' => getenv('DB_HOST') ?: 'localhost',
        'dbname' => getenv('DB_DATABASE') ?: 'small_social',
        'charset' => 'utf8mb4',
        'username' => getenv('DB_USERNAME') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: '',
    ],

    // Set to true to automatically login as 'admin' in local development
    'auto_login' => true,

    'middleware' => [
        'auth' =>  \App\Middleware\AuthMiddleware::class,
        'guest' =>  \App\Middleware\GuestMiddleware::class,
        'csrf' =>  \App\Middleware\CsrfMiddleware::class,
        'admin' => \App\Middleware\AdminMiddleware::class,
        'jwt' => \App\Middleware\JwtMiddleware::class,
    ]

];
