<?php

namespace App\Controllers\Api;


class SystemController
{
    public static function setCorsHeaders() {
        // DEV: allow all
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET,POST,PATCH,DELETE,OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Max-Age: 86400');
    }
    public function preflight() { self::setCorsHeaders(); http_response_code(204); }
}

