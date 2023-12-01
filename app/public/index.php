<?php
$requestUri = $_SERVER['REQUEST_URI'];
if ($requestUri === '/registrate') {
    require_once '../Controller/UserController.php';
    $userController = new UserController();
    $userController->registrate();
} elseif ($requestUri === '/login') {
    require_once '../Controller/UserController.php';
    $userController = new UserController();
    $userController->login();
} elseif ($requestUri === '/main') {
    require_once '../Controller/IndexController.php';
    $indexController = new indexController();
    $indexController->main();
} elseif ($requestUri === '/add-product') {
    require_once '../Model/Cart.php';
    require_once '../Controller/CartController.php';
    $cartController = new CartController();
    $cartController->addProduct();
} else {
    require_once '../View/404.html';
}
?>