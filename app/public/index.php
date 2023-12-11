<?php

use Controller\CartController;
use Controller\IndexController;
use Controller\UserController;
use Request\AddProductRequest;
use Request\LoginRequest;
use Request\RegistrationRequest;
use Request\Request;


$autoload = function (string $className) {
    $path = str_replace('\\', '/', $className);
    $path = dirname(__DIR__) . "/" . $path . ".php";

    if (file_exists($path)) {
        require_once $path;
    }
};

spl_autoload_register($autoload);

$routes = [
    '/registration' => [
        'GET' => [
            'class' => UserController::class,
            'method' => 'getRegistration',
        ],
        'POST' => [
            'class' => UserController::class,
            'method' => 'postRegistration',
            'request' => RegistrationRequest::class,
        ],

    ],
    '/login' => [
        'GET' => [
            'class' => UserController::class,
            'method' => 'getLogin',
        ],
        'POST' => [
            'class' => UserController::class,
            'method' => 'postLogin',
            'request' => LoginRequest::class,
        ],
    ],
    '/main' => [
        'GET' => [
            'class' => IndexController::class,
            'method' => 'getMain'
        ],
        'POST' => [
            'class' => CartController::class,
            'method' => 'postAddProduct',
            'request' => AddProductRequest::class,
        ],
    ],
//    '/add-product' => [
//        'GET' => [
//            'class' => CartController::class,
//            'method' => 'getAddProduct'
//        ],
//        'POST' => [
//            'class' => CartController::class,
//            'method' => 'postAddProduct',
//            'request' => AddProductRequest::class,
//        ],
//    ],
    '/cart' => [
        'GET' => [
            'class' => CartController::class,
            'method' => 'getCart'
        ]
    ],
];

$requestUri = $_SERVER['REQUEST_URI'];

if (isset($routes[$requestUri])) {
    $routeMethods = $routes[$requestUri];
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    if (isset($routeMethods[$requestMethod])) {
        $handler =$routeMethods[$requestMethod];
        $class = $handler['class'];
        $method = $handler['method'];
        $obj = new $class();

        if (isset($handler['request'])) {
            $requestClass = $handler['request'];
            $request = new $requestClass($requestMethod, $_POST);
        } else {
            $request = new Request($requestMethod, $_POST);
        }
        $obj->$method($request);
    } else {
        echo "Метод $requestMethod для $requestUri не поддерживается";
    }
} else {
    require_once '../View/404.html';
}