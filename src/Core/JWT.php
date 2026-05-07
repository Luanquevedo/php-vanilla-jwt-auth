<?php
namespace src\Core;

class JWT
{
    public static function encode(array $payload, int $expirationTime = 3600): string
    {
        $header = json_encode([
            'alg' => 'HS256',
            'typ' => 'JWT',
        ]);

        $issueAt        = time();
        $payload['iat'] = $issueAt;
        $payload['exp'] = $issueAt + $expirationTime;

        $payload = json_encode($payload);

        $encodedHeader  = self::base64urlEncode($header);
        $encodedPayload = self::base64urlEncode($payload);

        $signature = self::sign("$encodedHeader.$encodedPayload");

        return "$encodedHeader.$encodedPayload.$signature";
    }

    public static function decode(string $token): array | false
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }

        [$encodedHeader, $encodedPayload, $encodedSignature] = $parts;

        $expectedSignature = self::sign("$encodedHeader.$encodedPayload");

        if (! hash_equals($expectedSignature, $encodedSignature)) {
            return false;
        }

        $payload = json_decode(self::base64urlDecode($encodedPayload), true);

        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return false;
        }

        return $payload;
    }

    private static function sign(string $data): string
    {
        $secretKey = getenv('APP_KEY');

        if (! $secretKey) {
            throw new \Exception('CRÍTICO: SecretKey não definida');
        }

        $signature = hash_hmac('sha256', $data, $secretKey, true);

        return self::base64urlEncode($signature);
    }
    private static function base64urlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    private static function base64urlDecode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
