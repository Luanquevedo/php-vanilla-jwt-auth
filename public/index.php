<?php

require_once __DIR__ . '/../config/autoload.php';
require_once __DIR__ . '/../config/database.php';

use src\Core\Env;
use src\Core\Router;

Env::load(__DIR__ . '/../.env');
if (getenv('APP_DEBUG') === 'true') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$App         = getenv('APP_URL');
$key         = getenv('APP_KEY');
$Credentials = getenv('APP_CREDENTIALS');

header("Access-Control-Allow-Origin: $App");
header("Access-Control-Allow-Credentials: $Credentials");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Min-Age: 18");
header("Access-Control-Max-Age: 3600");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
$router = new Router();

require_once __DIR__ . '/../routes/api.php';

$router->run();
