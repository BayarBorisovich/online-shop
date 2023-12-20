<?php
namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Order;
use Model\OrdersItem;
use Model\Product;
use Model\User;
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
                foreach ($cartProducts as $cartProduct) {
                    $productId[] = $cartProduct->getProductId();
                }

                $products = Product::getAllByIds($productId); // продукты пользователя
                foreach ($products as $product) {
                    foreach ($cartProducts as $cartProduct) {
                        if ($cartProduct->getProductId() === $product->getId()) {
                            $arrayOfPrices[$product->getId()] = $product->getPrice()*$cartProduct->getQuantity();
                        }
                    }
                }

                OrdersItem::addOrdersItems($orderId, $cartProducts, $arrayOfPrices);
                header('location: /order-items');

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

            $users = User::addOneById($userId);

            $orders = Order::getOne($userId);
            $orderId = $orders->getId();

            $orderItems = OrdersItem::getOrdersItems($orderId);
            $productId = [];
            foreach ($orderItems as $elem) {
                $productId[] = $elem->getProductId();
            }

            $products = Product::getAllByIds($productId); // продукты пользователя
            foreach ($products as $product) {
                foreach ($orderItems as $orderItem) {
                    if ($orderItem->getProductId() === $product->getId()) {
                        $sumPrice[] = $product->getPrice()*$orderItem->getQuantity();
                    }
                }
            }
            $sumTotalCart = array_sum($sumPrice); // Общая сумма корзины;
        } else {
            header('location: /login');
        }
        require_once '../View/orderItem.phtml';
    }
}