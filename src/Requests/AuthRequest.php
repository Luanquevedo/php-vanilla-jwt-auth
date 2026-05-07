<?php
namespace src\Requests;

class AuthRequest
{
    public static function validate(): array
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (! $data) {
            return [
                'success' => false,
                'error'  => [
                    'Formado JSON invalido ou vazio',
                ],
            ];
        }

        $error = [];

        $email    = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email)) {
            $error[] = 'Email invalido ou vazio';
        }

        if (empty($password)) {
            $error[] = 'A senha é obrigatória';
        }

        if (! empty($error)) {
            return [
                'success' => false,
                'error'  => $error,
            ];
        }

        return [
            'success' => true,
            'data'    => [
                'email'    => $email,
                'password' => $password,
            ],
        ];
    }
}
