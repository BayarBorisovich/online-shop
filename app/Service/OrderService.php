<?php

namespace Service;
use Bayar\MyCore\Model\Model;
use Model\Cart;
use Model\CartProduct;
use Model\Order;
use Model\OrdersItem;
use Model\Product;

class OrderService
{
    public function create (int $userId, array $data): bool|string
    {
        $telephone = $data['telephone'];
        $city = $data['city'];
        $street = $data['street'];
        $house = $data['house'];
        $comments = $data['comments'];

        $order = Order::getOne($userId);
                if (!empty($order)) {
                    if ($order->getUserId() === $userId) {
                        $orderId = Order::getOne($userId)->getId();
                        OrdersItem::delete($orderId);
                        Order::delete($orderId, $userId);
                    }
                }

        $pdo = Model::getPDO();

        $cartProducts = CartProduct::getAllByUserId($userId); // все продукты в корзине у пользователя

        $products = Product::getAllByUserId($userId); // продукты пользователя

        foreach ($cartProducts as $cartProduct) {
            if (isset($products[$cartProduct->getProductId()])) {
                $product = $products[$cartProduct->getProductId()];
                $arrayOfPrices[$product->getId()] = $product->getPrice()*$cartProduct->getQuantity();
            }
        }

        $cartId = Cart::getOne($userId)->getId();

        $pdo->beginTransaction();

        try {
            Order::create($userId, $telephone, $city, $street, $house, $comments);
            $orderId = Order::getOne($userId)->getId();

            OrdersItem::create($orderId, $cartProducts, $arrayOfPrices);

            CartProduct::clear($cartId);

        } catch (\Throwable $exception) {
            $pdo->rollBack();
            echo $exception->getMessage();
        }
        return $pdo->commit();
    }
}