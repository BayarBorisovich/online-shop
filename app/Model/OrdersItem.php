<?php
namespace Model;
class OrdersItem extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $quantity;
    private int $price;

    public function __construct(int $id, int $orderId, int $productId, int $quantity, int $price)
    {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
    }
    public static function create(int $orderId, array $cartProducts, array $arrayOfPrices): bool
    {
        $stmt = self::getPDO()->prepare(query: 'INSERT INTO orders_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)');

        foreach ($cartProducts as $cartProduct) {
            foreach ($arrayOfPrices as $id => $price) {
                if ($cartProduct->getProductId() === $id) {
                    $result = $stmt->execute(['order_id' => $orderId, 'product_id' => $cartProduct->getProductId(), 'quantity' => $cartProduct->getQuantity(), 'price' => $price]);
                }
            }
        }
        return $result;
    }
    public static function getOrdersItems(int $orderId): array
    {
        $stmt = self::getPDO()->prepare(query: 'SELECT * FROM orders_items WHERE order_id = :order_id');
        $stmt->execute(['order_id' => $orderId]);
        $data = $stmt->fetchAll();
        $arr = [];
        foreach ($data as $elem) {
            $arr[] = new self($elem['id'], $elem['order_id'], $elem['product_id'], $elem['quantity'], $elem['price']);
        }
        return $arr;
    }
    public static function delete(int $order_id): bool
    {
        $stmt = self::getPDO()->prepare(query: 'DELETE FROM orders_items WHERE order_id = :order_id');
        return $stmt->execute([$order_id]);
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getOrderId(): int
    {
        return $this->orderId;
    }
    public function getProductId(): int
    {
        return $this->productId;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function getPrice(): int
    {
        return $this->price;
    }

}