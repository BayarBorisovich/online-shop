<?php

namespace Model;
use PDO;

class Cart extends Model
{
    private int $id;
    private string $name;
    private int $userId;

    public function __construct(int $id, string $name, int $userId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->userId = $userId;
    }

    public static function getOne(int $userId): Cart|null
    {
        $stmt = self::getPDO()->prepare(query: 'SELECT * FROM carts WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($data)) {
            return null;
        }
        return new self($data['id'], $data['name'], $data['user_id']);
    }
    public static function create(int $userId): bool
    {
        $stmt = self::getPDO()->prepare(query: 'INSERT INTO carts (name, user_id) VALUES (:name, :id)');
        return $stmt->execute(['name' => 'cart1', 'id' => $userId]);
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

}