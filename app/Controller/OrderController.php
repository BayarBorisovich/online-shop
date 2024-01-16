<?php
namespace Controller;
use Model\Order;
use Model\OrdersItem;
use Model\Product;
use Model\User;
use Request\OrderRegistrationRequest;
use Service\OrderService;

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

                $orderService = new OrderService();
                $orderService->create($userId, $requestGetBody);

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
//            var_dump($products);die;
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