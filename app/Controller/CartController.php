<?php
namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\AddProductRequest;

class CartController
{
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
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            $cart = Cart::getOne($userId);
            $cartId = $cart->getId();
            $cartProducts = CartProduct::getAll($cartId); // все продукты в корзине у пользователя

            $productIds = [];
            foreach ($cartProducts as $cartProduct) {
                $productIds[] = $cartProduct->getProductId();
            }
            $products = Product::getAllByIds($productIds); // продукты пользователя

            foreach ($products as $product) {
                foreach ($cartProducts as $cartProduct) {
                    if ($cartProduct->getProductId() === $product->getId()) {
                        $sumPrice[] = $product->getPrice()*$cartProduct->getQuantity();
//                        $productUser[] = $product->getName();

                    }
                }
            }
//            var_dump($productUser);die;
            $sumTotalCart = array_sum($sumPrice); // Общая сумма корзины;
//                var_dump($products);die;
            require_once '../View/cart.phtml';
        }

    }
}
