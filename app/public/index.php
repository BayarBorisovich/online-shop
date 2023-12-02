<?php
$requestUri = $_SERVER['REQUEST_URI'];
if ($requestUri === '/registration') {
    require_once '../Controller/UserController.php';
    $userController = new UserController();
    $userController->registration($_POST);
} elseif ($requestUri === '/login') {
    require_once '../Controller/UserController.php';
    $userController = new UserController();
    $userController->login($_POST);
} elseif ($requestUri === '/main') {
    require_once '../Controller/IndexController.php';
    $indexController = new IndexController();
    $indexController->main();
} elseif ($requestUri === '/add-product') {
    require_once '../Controller/CartController.php';
    $cartController = new CartController();
    $cartController->addProduct($_POST);
} else {
    require_once '../View/404.html';
}
?>