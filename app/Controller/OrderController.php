<?php
namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Order;
use Model\OrdersItem;
use Model\Product;
use Request\OrderRegistrationRequest;

class OrderController
{
    public function getOrderForm(): void
    {
        require_once '../View/order.phtml';
    }

    public function orderRegistration(OrderRegistrationRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {

            session_start();
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                $requestGetBody = $request->getBody();

                $telephone = $requestGetBody['telephone'];
                $city = $requestGetBody['city'];
                $street = $requestGetBody['street'];
                $house = $requestGetBody['house'];
                $comments = $requestGetBody['comments'];

                Order::creatOrders($userId, $telephone, $city, $street, $house, $comments);
                $order = Order::getOne($userId);
                $orderId = $order->getId();

                $cart = Cart::getOne($userId);
                $cartId = $cart->getId();

                $cartProducts = CartProduct::getAll($cartId); // все продукты в корзине у пользователя
                $productId = [];
                $quantity = [];
                foreach ($cartProducts as $cartProduct) {
                    $productId[] = $cartProduct->getProductId();
                    $quantity[] = $cartProduct->getQuantity();
                }
                $products = Product::getAllByIds($productId); // продукты пользователя
                foreach ($products as $product) {
                    foreach ($cartProducts as $cartProduct) {
                        if ($cartProduct->getProductId() === $product->getId()) {
                            $sumPrice[] = $product->getPrice()*$cartProduct->getQuantity();
                        }
                    }
                }
                $price = array_sum($sumPrice); // Общая сумма корзины;

                OrdersItem::addOrdersItems($orderId, $productId, $quantity, $price);
                header('location: /order');

            } else {
                header('location: /login');
            }
        } else {
            require_once '../View/order.phtml';
        }
    }
    public function getOrderItems(): void
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $order = Order::getOne($userId);
            $orderId = $order->getId();
            $orderItem = OrdersItem::getOrdersItems($orderId);

//            header('location: /order-items');
        } else {
            header('location: /login');
        }
        require_once '../View/orderItem.phtml';
    }
}