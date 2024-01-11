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

//    public static function getAllByCartId(int $cartId): array
//    {
//        $stmt = self::getPDO()->prepare(query: 'SELECT * FROM cart_products WHERE cart_id = :cart_id');
//        $stmt->execute(['cart_id' => $cartId]);
//        $data = $stmt->fetchAll();
//
//        $arr = [];
//        foreach ($data as $elem) {
//            $arr[] = new self($elem['id'], $elem['cart_id'], $elem['product_id'], $elem['quantity']);
//        }
//        return $arr;
//    }
    public static function getAllByUserId(int $userId): array
    {
        $stmt = self::getPDO()->prepare(query: 'SELECT cp.* FROM cart_products cp INNER JOIN carts c on cp.cart_id=c.id WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        $data = $stmt->fetchAll();

        $arr = [];
        foreach ($data as $elem) {
            $arr[] = new self($elem['id'], $elem['cart_id'], $elem['product_id'], $elem['quantity']);
        }
        return $arr;
    }
//    public static function getAllByProductId(int $productId): array
//    {
//        $stmt = self::getPDO()->prepare(query: 'SELECT * FROM cart_products WHERE product_id = :product_id');
//        $stmt->execute(['product_id' => $productId]);
//        $data = $stmt->fetchAll();
//
//        $arr = [];
//        foreach ($data as $elem) {
//            $arr[] = new self($elem['id'], $elem['cart_id'], $elem['product_id'], $elem['quantity']);
//        }
//        return $arr;
//    }
    public static function removingAproduct(int $productId, int $cartId): array|null
    {
        $stmt = self::getPDO()->prepare(query: 'DELETE FROM cart_products WHERE product_id = :product_id and cart_id = :cart_id');
        $stmt->execute([$productId, $cartId]);
        return $stmt->fetchAll();
    }
    public static function clear(int $cartId): bool
    {
        $stmt = self::getPDO()->prepare(query: 'DELETE FROM cart_products WHERE cart_id = :cart_id');
        return $stmt->execute([$cartId]);
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