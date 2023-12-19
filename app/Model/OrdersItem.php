<?php
namespace Model;
class OrdersItem extends Model
{
    private int $id;
    private int $orderId;
    private string $productId;
    private string $quantity;
    private int $price;

    public function __construct(int $id, int $orderId, string $productId, string $quantity, int $price)
    {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
    }
    public static function addOrdersItems(int $orderId, array $productId, array $quantity, int $price): bool
    {
        $productId = implode(', ', $productId);
        $quantity = implode(', ', $quantity);
        $stmt = self::getPDO()->prepare(query: 'INSERT INTO orders_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)');
        return $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'quantity' => $quantity, 'price' => $price]);
    }
    public static function getOrdersItems(int $orderId): ?OrdersItem
    {
        $stmt = self::getPDO()->prepare(query: 'SELECT * FROM orders_items WHERE order_id = :order_id');
        $stmt->execute(['order_id' => $orderId]);
        $data = $stmt->fetch();

        if (empty($data)) {
        return null;
    }
        return new self($data['id'], $data['order_id'], $data['product_id'], $data['quantity'], $data['price']);
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getOrderId(): int
    {
        return $this->orderId;
    }
    public function getProductId(): string
    {
        return $this->productId;
    }
    public function getQuantity(): string
    {
        return $this->quantity;
    }
    public function getPrice(): int
    {
        return $this->price;
    }

}