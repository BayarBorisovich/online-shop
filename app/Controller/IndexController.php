<?php
class IndexController
{
    public function main(): void
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $products = Product::getAll();
            echo 'Добро пожаловать в каталог Online-shop';
        } else {
            header('location: ../Controller/UserController.php');
        }
        require_once '../View/main.phtml';
    }
}
