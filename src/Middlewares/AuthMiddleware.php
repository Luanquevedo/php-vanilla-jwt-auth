<?php
namespace src\Middlewares;

use src\Core\JWT;

class AuthMiddleware
{
    public static function handle(): array
    {
        $headers    = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? $headers['X-Authorization'] ?? null;
        $token      = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        if (! $token && isset($_COOKIE['jwt_token'])) {
            $token = $_COOKIE['jwt_token'];
        }

        if (! $token) {
            self::unauthorized('Token de autenticação não encontrado');
        }

        $payload = JWT::decode($token);

        if (! $payload) {
            self::unauthorized('Token invalido ou expirado');
        }

        return $payload;
    }

    private static function unauthorized(string $message): void
    {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'error'   => $message,
        ]);
        exit;
    }
}
