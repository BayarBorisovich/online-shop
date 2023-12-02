<?php

require_once '../Model/ConnectingToTheDatabase.php';
class Cart extends ConnectingToTheDatabase
{
    public function getOne(int $userId): mixed
    {
        $stmt = $this->PDO->prepare(query: 'SELECT * FROM carts WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create(int $userId, string $name = null): bool
    {
        $stmt = $this->PDO->prepare(query: 'INSERT INTO carts ( name, user_id) VALUES (:name, :id)');
        return $stmt->execute(['name' => 'cart1', 'id' => $userId]);
    }
}