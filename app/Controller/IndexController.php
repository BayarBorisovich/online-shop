<?php



class indexController
{
    public function main(): void
    {
        session_start();
        if (isset($_SESSION['user_id'])) {

            $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
            $stmt = $pdo->query('SELECT * FROM products');
            $products = $stmt->fetchAll();

//            $productModel = new Product();
//            $products = $productModel->getAll();
            echo 'Добро пожаловать в каталог Online-shop';
        } else {
            header('location: ../Controller/UserController.php');
        }
        require_once '../View/main.phtml';
    }
}
