<?php

namespace App\Middleware;

use App\Contract\MiddlewareInterface;

class CsrfMiddleware implements MiddlewareInterface
{
    public static function handle()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!$token || $token !== $_SESSION['csrf_token']) {
                abort(419); // CSRF token mismatch
            }
        }
    }
}