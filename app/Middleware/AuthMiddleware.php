<?php

namespace App\Middleware;

use App\Contract\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public static function handle()
    {

        if (!(auth()->check())) {

            redirect('/login');
        }
    }
}
