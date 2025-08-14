<?php

namespace App\Middleware;

use App\Contract\MiddlewareInterface;

class GuestMiddleware implements MiddlewareInterface
{
    public static function handle()
    {
        if (isset($_SESSION['user'])) {
            // user has already logged in
            redirect('/');
        }
    }
}