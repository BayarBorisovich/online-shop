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

                    $cart = Cart::getOne($userId);
                    if (!isset($cart)) {
                        Cart::create($userId);

                        $cart = Cart::getOne($userId);
                    }
                    $cartId = $cart->getId();

                    CartProduct::create($cartId, $productId, $quantity);
                    header('location: /main');
                }
            }
        } else {
            header('location: /login');
        }


//        require_once '../Controller/IndexController.php';
    }
}