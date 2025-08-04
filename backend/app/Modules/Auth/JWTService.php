<?php
namespace App\Modules\Auth;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class JwtService
{
    private static string $secretKey = 'your_secret_key_here';
    private static string $algo = 'HS256';

    public static function generateToken(array $payload, int $expiryInSeconds = 3600): string
    {
        $issuedAt = time();
        $expireAt = $issuedAt + $expiryInSeconds;

        $payload['iat'] = $issuedAt;
        $payload['exp'] = $expireAt;

        return JWT::encode($payload, self::$secretKey, self::$algo);
    }

    public static function decodeToken(string $token)
    {
        try {
            $decoded = JWT::decode($token, new \Firebase\JWT\Key(self::$secretKey, self::$algo));
            return is_null($decoded) ? null : (array) $decoded;
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } catch (ExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Expired token'], 401);
        }
    }
}