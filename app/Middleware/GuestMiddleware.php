<?php

namespace App\Middleware;

use App\Contract\MiddlewareInterface;

class GuestMiddleware implements MiddlewareInterface
{
    public static function handle()
    {

        if (auth()->check()) {
            // user has already logged in
            redirect('/');
        }
    }
}
