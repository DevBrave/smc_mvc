<?php

namespace App\Middleware;

use App\Contract\MiddlewareInterface;
use App\Model\User;

class AdminMiddleware implements MiddlewareInterface
{
    public static function handle()
    {
       if(!User::isAdmin($_SESSION['user'])){
           // not an admin user

           redirect('/');
       }
    }
}