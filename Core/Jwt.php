<?php

namespace Core;

class Jwt
{

    private static $secret = 'CHANGE_ME_SUPER_SECRET_32B';
    public static function encode(array $payload, int $ttl = 14400): string
    {
        $h = ['alg' => 'HS256', 'typ' => 'JWT'];
        $now = time();
        $payload += ['iat' => $now, 'exp' => $now + $ttl];
        $seg = [self::b64(json_encode($h)), self::b64(json_encode($payload))];
        $sig = hash_hmac('sha256', implode('.', $seg), self::$secret, true);
        $seg[] = self::b64($sig);
        return implode('.', $seg);
    }

    public static function decode(string $jwt): ?array
    {
        $p = explode('.', $jwt);
        if (count($p) !== 3) return null;
        [$h, $pl, $s] = $p;
        $expSig = hash_hmac('sha256', "$h.$pl", self::$secret, true);
        if (!hash_equals($expSig, self::ub64($s))) return null;
        $payload = json_decode(self::ub64($pl), true);
        if (!$payload || ($payload['exp'] ?? 0) < time()) return null;
        return $payload;
    }

    private static function b64($d)
    {
        return rtrim(strtr(base64_encode($d), '+/', '-_'), '=');
    }

    private static function ub64($d)
    {
        return base64_decode(strtr($d, '-_', '+/'));
    }
}
