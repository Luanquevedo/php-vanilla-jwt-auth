<?php

$prefix = '/api/v1';

const ROUTES = [
    [
        'method'     => 'POST',
        'path'       => '/register',
        'controller' => 'RegisterController@register',
        'middleware' => null, 
    ],
    [
        'method'     => 'POST',
        'path'       => '/login',
        'controller' => 'AuthController@login',
        'middleware' => null, 
    ],
    [
        'method'     => 'GET',
        'path'       => '/health-check',
        'controller' => 'SystemController@status',
        'middleware' => null, 
    ],
    [
        'method'     => 'GET',
        'path'       => '/me',
        'controller' => 'UserController@profile',
        'middleware' => 'AuthMiddleware',
    ],
];

foreach (ROUTES as $route) {
    $fullPath = $prefix . $route['path'];
    $method   = strtolower($route['method']);
    $router->$method($fullPath, $route['controller'], $route['middleware']);
}
