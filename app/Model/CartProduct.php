<?php
require_once '../Model/Model.php';
class CartProduct extends Model
{
    public function create(int $cartId, int $productId, int $quantity): bool
    {
        $stmt = $this->PDO->prepare(query: 'INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)');
        return $stmt->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
    }
}