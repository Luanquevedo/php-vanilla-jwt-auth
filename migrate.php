<?php

require_once __DIR__ . '/config/autoload.php';
require_once __DIR__ . '/config/database.php';

use src\Core\Env;
use config\Database;

Env::load(__DIR__ . '/.env');

try {
    $pdo = Database::getConn();
    echo "Conectado ao banco de dados com sucesso!\n";

    $migrationsPath = __DIR__ . '/Database/Migrations/';
    $files = scandir($migrationsPath);

    foreach ($files as $file) {
        if ($file === '.' || $file === '..' || pathinfo($file, PATHINFO_EXTENSION) !== 'php') {
            continue;
        }

        require_once $migrationsPath . $file;
        
        $className = pathinfo($file, PATHINFO_FILENAME);

        if (class_exists($className)) {
            echo "Rodando migration: $className...\n";
            $migration = new $className();
            $migration->up($pdo);
            echo "Tabela processada com sucesso.\n";
        }
    }

    echo "\nTodas as migrations foram finalizadas!\n";
} catch (Exception $e) {
    echo "ERRO AO EXECUTAR MIGRATIONS: " . $e->getMessage() . "\n";
}