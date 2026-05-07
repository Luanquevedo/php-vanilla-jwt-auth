<?php
namespace src\Models;

use config\Database;
use PDO;
use PDOException;

class User
{
    public static function create(array $data): array
    {
        $pdo = Database::getConn();

        $uuid = self::generateUuidV7();

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql            = "INSERT INTO users (id, full_name, email, password, birth_date)
                VALUES (:id, :full_name, :email, :password, :birth_date)";

        try {
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id'         => $uuid,
                ':full_name'  => $data['name'],
                ':email'      => $data['email'],
                ':password'   => $hashedPassword,
                ':birth_date' => $data['birth'],
            ]);

            return [
                'success' => true,
                'uuid'    => $uuid,
            ];
        } catch (PDOException $e) {

            if ($e->getCode() === '23000') {
                return [
                    'success' => false,
                    'error'   => 'Email já cadastrado',
                ];
            }
            return [
                'success' => false,
                'error'   => 'Erro interno ao salvar no banco de dados',
            ];
        }
    }

    public static function login(array $data): array
    {
        $pdo = Database::getConn();

        try {
            $sql  = 'SELECT id, full_name, password FROM users WHERE email = :email LIMIT 1';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $data['email']]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($data['password'], $user['password'])) {

                unset($user['password']);
                return [
                    'success' => true,
                    'user'    => $user,
                ];

            }

            return [
                'success' => false,
                'error'   => 'Email ou senha invalidos',
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'error'   => 'Erro interno ao consultar o banco de dados',
            ];
        }
    }

    private static function generateUuidV7(): string
    {
        $timeMS  = (int) (microtime(true) * 1000);
        $timeHex = str_pad(dechex($timeMS), 12, '0', STR_PAD_LEFT);

        $random    = random_bytes(10);
        $random[0] = chr((ord($random[0])&0x0f) | 0x70);
        $random[2] = chr((ord($random[2])&0x3f) | 0x80);

        $randomHex = bin2hex($random);

        return sprintf(
            '%s-%s-%s-%s-%s',
            substr($timeHex, 0, 8),
            substr($timeHex, 8, 4),
            substr($randomHex, 0, 4),
            substr($randomHex, 4, 4),
            substr($randomHex, 8, 12)
        );
    }
}
