<?php

spl_autoload_register(function ($class) {
    $maps = [
        'src\\'    => __DIR__ . '/../src/',
        'config\\' => __DIR__ . '/../config/',
    ];
    //verificação de prefix da classe
    foreach ($maps as $prefix => $base_dir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }
        //captura de class name
        $relative_class = substr($class, $len);

        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
});
