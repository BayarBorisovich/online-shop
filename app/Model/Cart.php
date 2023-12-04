<?php

require_once '../Model/Model.php';
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

    public static function getOne(int $userId): Cart
    {
        parent::getPdo1();
        $stmt = self::$PDO1->prepare(query: 'SELECT * FROM carts WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return new self($data['id'], $data['name'], $data['user_id']);
    }
    public function create(int $userId, string $name = null): bool
    {
        $stmt = $this->PDO->prepare(query: 'INSERT INTO carts ( name, user_id) VALUES (:name, :id)');
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