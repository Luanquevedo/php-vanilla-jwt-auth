<?php
namespace config;

use PDO;
use PDOException;

class Database
{

    private static $conn = null;

    public static function getConn(): PDO
    {
        if (self::$conn === null) {
            try {
                $driver   = getenv('DB_CONNECTION') ?: 'mysql';
                $host     = getenv('DATABASE_HOST');
                $port     = getenv('DB_PORT');
                $db       = getenv('DB_NAME');
                $user     = getenv('DB_USER');
                $password = getenv('DB_PASSWORD');
                $charset  = 'utf8mb4';

                // Formato DSN: driver:host=xxx;dbname=xxx;charset=xxx
                $dsn = "{$driver}:host={$host};port={$port};dbname={$db};charset={$charset}";

                self::$conn = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);

            } catch (PDOException $exception) {
                http_response_code(500);
                die(json_encode([
                    "error"   => "Falha na conexão com o banco de dados",
                    "details" => $exception->getMessage(),
                ]));
            }
        }
        return self::$conn;

    }

}
