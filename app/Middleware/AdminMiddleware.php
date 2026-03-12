<?php

namespace App\Middleware;

use App\Contract\MiddlewareInterface;
use App\Model\User;

class AdminMiddleware implements MiddlewareInterface
{
    public static function handle()
    {
        if (!auth()->isAdmin()) {

            // not an admin user
            redirect('/');
        }
    }
}
