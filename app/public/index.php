<?php

use Controller\CartController;
use Controller\IndexController;
use Controller\OrderController;
use Controller\UserController;
use Request\AddProductRequest;
use Request\LoginRequest;
use Request\OrderRegistrationRequest;
use Request\RegistrationRequest;
use Service\Authentication\AuthenticationInterface;

require_once "../Autoloader.php";
Autoloader::registrate(dirname(__DIR__)); //значение текущей родительской директории

$dependencies = include '../Config/Dependencies.php';

$container = new Container($dependencies);

//$container->set(UserController::class, function (Container $container) {
//    $authenticationService = $container->get(AuthenticationInterface::class);
//
//    return new UserController($authenticationService);
//});
//
//$container->set(CartController::class, function (Container $container) {
//    $authenticationService = $container->get(AuthenticationInterface::class);
//
//    return new CartController($authenticationService);
//});
//
//$container->set(IndexController::class, function (Container $container) {
//    $authenticationService = $container->get(AuthenticationInterface::class);
//
//    return new IndexController($authenticationService);
//});
//
//$container->set(OrderController::class, function (Container $container) {
//    $orderService = new \Service\OrderService();
//    $authenticationService = $container->get(AuthenticationInterface::class);
//
//    return new OrderController($orderService, $authenticationService);
//});
//
//$container->set(AuthenticationInterface::class, function () {
//    return new \Service\Authentication\SessionAuthenticationService();
//});

$app = new App($container);// почему не делаем require_once

$app->get('/registration', UserController::class, 'getRegistration');
$app->post('/registration', UserController::class, 'postRegistration', RegistrationRequest::class);

$app->get('/login', UserController::class, 'getLogin',);
$app->post('/login', UserController::class, 'postLogin', LoginRequest::class,);

$app->get('/main', IndexController::class, 'getMain');
$app->post('/main', CartController::class, 'postAddProduct', AddProductRequest::class,);

$app->get('/cart', CartController::class, 'getCart');
$app->post('/cart', CartController::class,'deleteAnItem', AddProductRequest::class,);

$app->get('/order', OrderController::class, 'getOrderForm',);
$app->post('/order', OrderController::class, 'orderRegistration', OrderRegistrationRequest::class);

$app->get('/order-items', OrderController::class, 'getOrderItems',);

$app->run();

