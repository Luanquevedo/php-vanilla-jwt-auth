<?php
namespace src\Controllers;

use src\Core\JWT;
use src\Models\User;
use src\Requests\AuthRequest;

class AuthController
{

    public function login(): void
    {
        $validation = AuthRequest::validate();

        if (! $validation['success']) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'error'  => $validation['error'],
            ]);
            return;
        }

        $result = User::login($validation['data']);

        if (! $result['success']) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'error'   => $result['error'],
            ]);
            return;
        }

        $token = JWT::encode($result['user']);

        setcookie('jwt_token', $token, time() + 3600, '/', '', true, true);
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Login realizado com sucesso',
            'token'   => $token,
        ]);
    }

}
