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
        'auth' =>  \App\Middleware\AuthMiddleware::class,
        'guest' =>  \App\Middleware\GuestMiddleware::class,
        'csrf' =>  \App\Middleware\CsrfMiddleware::class,
        'admin' => \App\Middleware\AdminMiddleware::class,
        'jwt' => \App\Middleware\JwtMiddleware::class,
    ]

];




