<?php
namespace src\Controllers;

class UserController
{
    public function profile(): void
    {
        echo json_encode([
            'success' => true,
            'message' => 'Acesso autorizado à área VIP',
            'data'    => [
                'info' => 'Token validado com sucesso',
            ],
        ]);
    }
}
