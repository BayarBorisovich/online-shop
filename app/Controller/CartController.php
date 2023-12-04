<?php

class CartController
{
    public function addProduct($data): void
    {   $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestMethod === 'POST') {
            if (isset($data['product_id']) && isset($data['quantity'])) {
                $productId = $data['product_id'];
                $quantity = $data['quantity'];

                session_start();
                if (isset($_SESSION['user_id'])) {
                    $userId = $_SESSION['user_id'];

//                    require_once '../Model/Cart.php';
                    $cartModel = new Cart();
                    $cart = $cartModel->getOne($userId);
                    if (empty($cart)) {
                        $cartModel->create($userId);

                        $cart = $cartModel->getOne($userId);
                    }
                    $cartId = $cart['id'];
//                    require_once '../Model/CartProduct.php';
                    $cartProductModel = new CartProduct();
                    $cartProductModel->create($cartId, $productId, $quantity);
                    header('location: /main');
                }
            }
        } else {
            header('location: /login');
        }


//        require_once '../Controller/IndexController.php';
    }
}