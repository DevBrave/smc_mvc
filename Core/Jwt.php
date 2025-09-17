<?php

namespace Core;

class Jwt
{

    private static $secret = 'CHANGE_ME_SUPER_SECRET_32B';
    public static function encode(array $payload, int $ttlSeconds = 3600): string {
        $header = ['alg'=>'HS256','typ'=>'JWT'];
        $now = time();
        $payload = array_merge($payload, ['iat'=>$now,'exp'=>$now+$ttlSeconds]);
        $segments = [
            self::b64(json_encode($header)),
            self::b64(json_encode($payload))
        ];
        $signingInput = implode('.', $segments);
        $signature = hash_hmac('sha256', $signingInput, self::$secret, true);
        $segments[] = self::b64($signature);
        return implode('.', $segments);
    }

    public static function decode(string $jwt): ?array {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) return null;
        list($h, $p, $s) = $parts;
        $sig = self::ub64($s);
        $valid = hash_hmac('sha256', "$h.$p", self::$secret, true);
        if (!hash_equals($valid, $sig)) return null;
        $payload = json_decode(self::ub64($p), true);
        if (!$payload || ($payload['exp'] ?? 0) < time()) return null;
        return $payload;
    }

    private static function b64($data) { return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); }
    private static function ub64($data){ return base64_decode(strtr($data, '-_', '+/')); }
  
}
