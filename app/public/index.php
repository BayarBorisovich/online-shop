<?php

use Bayar\MyCore\App;
use Bayar\MyCore\Autoloader;
use Bayar\MyCore\Container\Container;
use Controller\CartController;
use Controller\IndexController;
use Controller\OrderController;
use Controller\UserController;
use Request\AddProductRequest;
use Request\LoginRequest;
use Request\OrderRegistrationRequest;
use Request\RegistrationRequest;





require_once "../../vendor/bayar/my-core/src/Autoloader.php";
Autoloader::registrate(dirname(__DIR__)); //значение текущей родительской директории

require_once "../../vendor/autoload.php";

$dependencies = include '../Config/Dependencies.php'; // включает и выполняет указанный файл(зависимости).

//require_once "../../vendor/bayar/my-core/src/Container/Container.php";
$container = new Container($dependencies);

//require_once "../../vendor/bayar/my-core/src/App.php";
$app = new App($container);// передаем зависимоти

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

