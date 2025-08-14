<?php


use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Middleware\GuestMiddleware;

return [
    'database' => [

        'host' => 'localhost',
        'dbname' => 'small_social',
        'charset' => 'utf8mb4'


    ],

    'middleware' => [
        'auth' => AuthMiddleware::class,
        'guest' => GuestMiddleware::class,
        'csrf' => CsrfMiddleware::class,
        'admin' => \App\Middleware\AdminMiddleware::class,
    ]

];




