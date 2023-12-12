<?php
namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\AddProductRequest;

class CartController
{
    public function getAddProduct(): void
    {
        require_once '../Controller/IndexController.php';
    }
    public function postAddProduct(AddProductRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {

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
            require_once '../Controller/IndexController.php';
        }
    }
    public function getCart(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestMethod === 'GET') {

            session_start();
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                $cart = Cart::getOne($userId);
                $cartId = $cart->getId();
                $cartProducts = CartProduct::getAll($cartId); // все продукты у пользователя

                $productIds = [];
                foreach ($cartProducts as $cartProduct) {
                    $productIds[] = $cartProduct->getProductId();
                }
                $products = Product::getAllByIds($productIds);

                foreach ($products as $product) {
                    foreach ($cartProducts as $cartProduct) {
                        if ($cartProduct->getProductId() === $product->getId()) {
                            $results[] = $product->getPrice();
                        }
                    }
                }
                $sum = array_sum($results);
//                var_dump($sum);die;
                require_once '../View/cart.phtml';
            }
        } else {
            header('location: /main');
        }

    }
}
