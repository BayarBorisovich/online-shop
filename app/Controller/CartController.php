<?php
namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Request\RegistrationRequest;
use Request\Request;

class CartController
{
    public function addProduct(RegistrationRequest $request): void
    {
        if (isset($request->getBody()['product_id']) && isset($request->getBody()['quantity'])) {
            $productId = $request->getBody()['product_id'];
            $quantity = $request->getBody()['quantity'];

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
        } else {
            header('location: /login');
        }
//        require_once '../Controller/IndexController.php';
    }
}