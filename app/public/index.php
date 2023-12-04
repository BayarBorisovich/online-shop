<?php
$requestUri = $_SERVER['REQUEST_URI'];

$autoload1 = function (string $className) {
    $path = "../Controller/$className.php";
    if (file_exists($path)) {
        require_once $path;
    }
};

$autoload2 = function (string $className) {
    $path = "../Model/$className.php";
    if (file_exists($path)) {
        require_once $path;
    }
};

spl_autoload_register($autoload1);
spl_autoload_register($autoload2);


if ($requestUri === '/registration') {
    $userController = new UserController();
    $userController->registration($_POST);
} elseif ($requestUri === '/login') {
    $userController = new UserController();
    $userController->login($_POST);
} elseif ($requestUri === '/main') {
    $indexController = new IndexController();
    $indexController->main();
} elseif ($requestUri === '/add-product') {
    $cartController = new CartController();
    $cartController->addProduct($_POST);
} else {
    require_once '../View/404.html';
}
