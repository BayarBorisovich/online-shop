<?php

class CartController
{
    public function addProduct (): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestMethod === 'POST') {

            if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
                $productId = $_POST['product_id'];
                $quantity = $_POST['quantity'];

                session_start();
                if (isset($_SESSION['user_id'])) {
                    $userId = $_SESSION['user_id'];

                    $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

                    $cartModel = new Cart();
                    $cart = $cartModel->getOne($userId);

                    if (empty($cart)) {
                        $cartModel->create($userId);

                        $cart = $cartModel->getOne($userId);
                    }
                    $cartId = $cart['id'];

                    $cartProductModel = new CartProduct();
                    $cartProductModel->creat($cartId);
                    header('location: /main');
                }
            }
        } else {
            header('location: /login');
        }


        require_once '../Controller/IndexController.php';
    }
}