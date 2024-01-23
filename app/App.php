<?php

use Request\Request;
use Service\LoggerService;

class App
{
    private Container $container;
    private LoggerService $loggerService;
    private array $routes = [];
//    public function setContainer(Container $container): void
//    {
//        $this->container = $container;
//        $this->loggerService = $container->get(LoggerService::class);
//    }

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->loggerService = $container->get(LoggerService::class);
    }

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

                $obj = $this->container->get($class);

                if (isset($handler['request'])) {
                    $requestClass = $handler['request'];
                    $request = new $requestClass($requestMethod, $_POST);
                } else {
                    $request = new Request($requestMethod, $_POST);
                }
                try{
                    $obj->$method($request);
                } catch (Throwable $throwable) {

                    $this->loggerService->error($throwable);
                    require_once '../View/500.html';
                }

            } else {
                echo "Метод $requestMethod для $requestUri не поддерживается";
            }
        } else {
            require_once '../View/404.html';
        }
    }
    public function get(string $name, string $className, string $method, string $request = null): void
    {
        $this->routes[$name]['GET'] = [
            'class' => $className,
            'method' => $method,
            'request' => $request,
        ];
    }
    public function post(string $name, string $className, string $method, string $request = null): void
    {
        $this->routes[$name]['POST'] = [
            'class' => $className,
            'method' => $method,
            'request' => $request,
        ];
    }
    public function put(string $name, string $className, string $method, string $request = null): void
    {
        $this->routes[$name]['PUT'] = [
            'class' => $className,
            'method' => $method,
            'request' => $request,
        ];
    }
    public function heat(string $name, string $className, string $method, string $request = null): void
    {
        $this->routes[$name]['HEAT'] = [
            'class' => $className,
            'method' => $method,
            'request' => $request,
        ];
    }

}