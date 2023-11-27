<?php
//echo 'test';
$requestUri = $_SERVER['REQUEST_URI'];
if ($requestUri === '/registrate') {
    require_once './handler/registrate.php';
} elseif ($requestUri === '/login') {
    require_once './handler/login.php';
} elseif ($requestUri === '/main') {
    require_once './handler/main.php';
} elseif ($requestUri === '/add-product') {
    require_once './handler/addProduct.php';
} else {
    require_once './html/404.html';
}
?>