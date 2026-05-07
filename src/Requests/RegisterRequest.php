<?php
namespace src\Requests;

class RegisterRequest
{

    public static function validate(): array
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (! $data) {
            return [
                'success' => false,
                'errors'  => [
                    'Formato JSON invalido ou vazio',
                ],
            ];
        }

        $errors = [];

        $name     = trim($data['name'] ?? '');
        $email    = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';
        $confirm  = $data['confirm'] ?? ''; 
        $birth    = $data['birth'] ?? '';

        if (empty($name) || strlen($name) < 3) {
            $errors[] = 'O nome deve conter ao menos 3 caracteres';
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email invalido';
        }

        if (empty($password) || strlen($password) < 8) {
            $errors[] = 'A senha deve conter ao menos 8 caracteres';
        }

        if (empty($confirm) || $password !== $confirm) {
            $errors[] = 'As senhas não conferem';
        }

        if (empty($birth)) {
            $errors[] = 'A data de nascimento é obrigatória';
        }

        if (! empty($errors)) {
            return [
                'success' => false,
                'errors'  => $errors,
            ];
        }

        return [
            'success' => true,
            'data'    => [
                'name'     => $name,
                'email'    => $email,
                'password' => $password,
                'birth'    => $birth,
            ],
        ];
    }
}
