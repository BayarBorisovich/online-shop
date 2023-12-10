<?php

use Controller\CartController;
use Controller\IndexController;
use Controller\UserController;
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
            'request' => RegistrationRequest::class
        ]

    ],
    '/login' => [
        'GET' => [
            'class' => UserController::class,
            'method' => 'getLogin',
        ],
        'POST' => [
            'class' => UserController::class,
            'method' => 'postLogin',
            'request' => LoginRequest::class
        ],
    ],
    '/main' => [
        'GET' => [
            'class' => IndexController::class,
            'method' => 'getMain',
        ],
        'POST' => [
            'class' => IndexController::class,
            'method' => 'postMain',
        ],
    ],
    '/add-product' => [
        'class' => CartController::class,
        'method' => 'addProduct'
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
        $requestClass = $handler['request'];

        $obj = new $class();
        $request = new $requestClass($requestMethod, $_POST);

        $obj->$method($request);
//        if (!empty($handler['request'])) {
//            $requestClass = $handler['request'];
//            $obj = new $class();
//            $request = new $requestClass($requestMethod, $_POST);
//        } else {
//            $obj = new $class();
//            $request = new Request($requestMethod, $_POST);
//        }
//        $obj->$method($request);
    } else {
        echo "Метод $requestMethod для $requestUri не поддерживается";
    }
} else {
    require_once '../View/404.html';
}

//if ($requestUri === '/registration') {
//    $userController = new UserController();
//    $userController->registration($_POST);
//} elseif ($requestUri === '/login') {
//    $userController = new UserController();
//    $userController->login($_POST);
//} elseif ($requestUri === '/main') {
//    $indexController = new IndexController();
//    $indexController->main();
//} elseif ($requestUri === '/add-product') {
//    $cartController = new CartController();
//    $cartController->addProduct($_POST);
//} else {
//    require_once '../View/404.html';
//}
