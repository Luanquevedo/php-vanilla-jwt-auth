<?php
namespace src\Controllers;

class SystemController
{
    public function status(): void
    {
        http_response_code(200);
        echo json_encode([
            'success'     => true,
            'message'     => 'API Online',
            'timestamp'   => date('Y-m-d H:i:s'),
            'php_version' => PHP_VERSION,
            'memory_use'  => round(memory_get_usage() / 1024 / 1024, 2) . ' MB',
        ]);
    }
}
