<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
    $stmt = $pdo->query('SELECT * FROM products');
    $products = $stmt->fetchAll();
    echo 'Добро пожаловать в каталог Online-shop';
} else {
    header('location: ./handler/login.php');
}
//if (isset($_COOKIE['login'])) {
//    $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
//    $stmt = $pdo->query("SELECT * FROM products");
//    $products = $stmt->fetchAll();
//    echo 'Добро пожаловать в каталог Online-shop';
//} else {
//    header('location: ./handler/login.php');
//}
require_once './html/main.phtml';