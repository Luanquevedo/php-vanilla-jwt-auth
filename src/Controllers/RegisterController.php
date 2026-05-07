<?php
namespace src\Controllers;

use src\Models\User;
use src\Requests\RegisterRequest;

class RegisterController
{
    public function register(): void
    {
        $validation = RegisterRequest::validate();

        if (! $validation['success']) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'errors'  => $validation['errors'],
            ]);
            return;
        }

        $result = User::create($validation['data']);

        if (! $result['success']) {
            http_response_code(409);
            echo json_encode([
                'success' => false,
                'error'   => $result['error'],
            ]);
            return;
        }

        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Usuraio criado com sucesso',
            'data'    => [
                'id' => $result['uuid'],
            ],
        ]);
    }
}
