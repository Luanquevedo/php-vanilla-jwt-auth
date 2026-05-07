<?php

class User_migration
{
    //definição como a tabela deve ser criada.
    public function up(PDO $pdo): void
    {
        $sql = "
       CREATE TABLE IF NOT EXISTS users (
                id CHAR(36) NOT NULL, -- Para o UUID v7
                full_name VARCHAR(150) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                birth_date DATE NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

        $pdo->exec($sql);
    }
//definição de reversão de tabela
    public function down(PDO $pdo): void
    {
        $sql = 'DROP TABLE IF EXISTS users;';
        $pdo->exec($sql);
    }

}
