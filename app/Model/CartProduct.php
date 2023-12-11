<?php
namespace Model;
use PDO;

class CartProduct extends Model
{
    private int $id;
    private int $cardId;
    private int $productId;
    private int $quantity;

    public function __construct(int $id, int $cardId, int $productId, int $quantity)
    {
        $this->id = $id;
        $this->cardId = $cardId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }
    public static function create(int $cartId, int $productId, int $quantity): bool
    {
        $stmt = self::getPDO()->prepare(query: 'INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)');
        return $stmt->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public static function getAll(int $cartId): array
    {
        $stmt = self::getPDO()->prepare(query: 'SELECT * FROM cart_products WHERE cart_id = :cart_id');
        $stmt->execute(['cart_id' => $cartId]);
        $data = $stmt->fetchAll();

        $arr = [];
        foreach ($data as $elem) {
            $arr[] = new self($elem['id'], $elem['cart_id'], $elem['product_id'], $elem['quantity']);
        }
        return $arr;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCardId(): int
    {
        return $this->cardId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}