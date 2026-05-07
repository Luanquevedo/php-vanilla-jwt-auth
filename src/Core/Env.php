<?php
namespace src\Core;

class Env
{
    public static function load(string $path)
    {
        if (! file_exists($path)) {
            return;
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);

            if (strpos($line, '#') === 0 || strpos($line, '=') === false) {
                continue;
            }
            // Ignora comentários
            list($name, $value) = explode('=', $line, 2);
            $name               = trim($name);
            $value              = trim($value);

            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name]    = $value;
            $_SERVER[$name] = $value;
        }

    }

}
