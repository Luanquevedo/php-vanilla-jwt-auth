<?php
namespace src\Core;
class Router
{
    private array $routes = [];

    public function post(string $path, string $handle, $middleware = null)
    {
        $this->routes['POST'][$path] = ['handler' => $handle, 'middleware' => $middleware];
    }
    public function get(string $path, string $handle, $middleware = null)
    {
        $this->routes['GET'][$path] = ['handler' => $handle, 'middleware' => $middleware];
    }

    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$method][$uri])) {
            $route   = $this->routes[$method][$uri];
            $handler = $route['handler'];

            if ($route['middleware']) {
                $middlewareClass = "src\\Middlewares\\" . $route['middleware'];
                if (class_exists($middlewareClass)) {
                    $middlewareClass::handle();
                }
            }

            list($controllerName, $methodName) = explode('@', $handler);

            $controllerClass = "src\\Controllers\\" . $controllerName;

            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                $controller->$methodName();
                return;
            }
        }
        http_response_code(404);
        echo json_encode(["error" => "Rota não encontrada"]);
    }
}
