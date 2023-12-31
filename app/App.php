<?php

use Controller\CartController;
use Controller\IndexController;
use Controller\OrderController;
use Controller\OrderItemsController;
use Controller\UserController;
use Request\AddProductRequest;
use Request\LoginRequest;
use Request\OrderRegistrationRequest;
use Request\RegistrationRequest;
use Request\Request;

class App
{
    private array $routes = [ // свойство
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
        '/cart' => [
            'GET' => [
                'class' => CartController::class,
                'method' => 'getCart'
            ],
            'POST' => [
                'class' => CartController::class,
                'method' => 'deleteAnItem',
                'request' => AddProductRequest::class,
            ],
        ],
        '/order' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getOrderForm',
            ],
            'POST' => [
                'class' => OrderController::class,
                'method' => 'orderRegistration',
                'request' => OrderRegistrationRequest::class
            ],
        ],
        '/order-items' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getOrderItems',
            ],
        ],
    ];
    public function run(): void // запустить
    {
        $requestUri = $_SERVER['REQUEST_URI'];

        if (isset($this->routes[$requestUri])) {
            $routeMethods = $this->routes[$requestUri];
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
            require_once './View/404.html';
        }
    }
}