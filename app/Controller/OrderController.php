<?php
namespace Controller;
use Model\Order;
use Model\OrdersItem;
use Model\Product;
use Model\User;
use Request\OrderRegistrationRequest;
use Service\Authentication\AuthenticationInterface;
use Service\Authentication\SessionAuthenticationService;
use Service\OrderService;

class OrderController
{
    private OrderService $orderService;
    private AuthenticationInterface $authenticationService;

    public function __construct(OrderService $orderService, AuthenticationInterface $authenticationService)
    {
        $this->orderService = $orderService;
        $this->authenticationService = $authenticationService;
    }
    public function getOrderForm(): void
    {
        require_once '../View/order.phtml';
    }

    public function orderRegistration(OrderRegistrationRequest $request): void
    {
        $user = $this->authenticationService->getCurrentUser();

        if (empty($user)) {
            header('location: /login');
        }
        $errors = $request->validate();

        if (empty($errors)) {
            $requestGetBody = $request->getBody();

            $this->orderService->create($user->getId(), $requestGetBody);

            header('location: /order-items');
        }
        require_once '../View/order.phtml';

    }
    public function getOrderItems(): void
    {
        $user = $this->authenticationService->getCurrentUser();

        if (empty($user)) {
            header('location: /login');
        }
        $users = User::addOneById($user->getId());

        $orders = Order::getOne($user->getId());
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

        require_once '../View/orderItem.phtml';
    }
}