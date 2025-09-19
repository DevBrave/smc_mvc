<?php

namespace App\Middleware;

use App\Contract\MiddlewareInterface;
use app\Model\User;
use Core\Jwt;

class JwtMiddleware implements MiddlewareInterface
{
    public static function handle()
    {
        $hdr = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (!preg_match('/Bearer\s+(.+)/i', $hdr, $m)) {
            self::deny('MISSING_TOKEN', 'Authorization Bearer token required', 401);
        }
        $payload = Jwt::decode(trim($m[1]));
        if (!$payload) {
            self::deny('INVALID_TOKEN', 'Token invalid or expired', 401);
        }
        // Make user info available (e.g., global or request context)
        $GLOBALS['auth_user_id'] = $payload['sub'];
        $GLOBALS['auth_user_role'] = $payload['role'] ?? 'user';
    }

    private static function deny($code,$msg,$status){
        header('Content-Type: application/json'); http_response_code($status);
        echo json_encode(['error'=>['code'=>$code,'message'=>$msg]]);
        exit;
    }
}