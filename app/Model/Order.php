<?php
namespace Model;
use PDO;

class Order extends Model
{
    private int $id;
    private string $telephone;
    private string $city;
    private string $street;
    private string $house;
    private string $comments;
    public function __construct(int $id, string $telephone, string $city, string $street, string $house, string $comments = null)
    {
        $this->id = $id;
        $this->telephone = $telephone;
        $this->city = $city;
        $this->street = $street;
        $this->house = $house;
        $this->comments = $comments;
    }
    public static function creatOrders(string $userId, string $telephone, string $city, string $street, string $house, string $comments,): bool
    {
        $stmt = self::getPDO()->prepare(query: 'INSERT INTO orders (user_id, telephone, city, street, house, comments) VALUES (:user_id, :telephone, :city, :street, :house, :comments)');
        return $stmt->execute(['user_id' => $userId, 'telephone' => $telephone, 'city' => $city, 'street' => $street, 'house' => $house, 'comments' => $comments]);
    }
    public static function getOne(int $userId): Order|null
    {
        $stmt = self::getPDO()->prepare(query: 'SELECT * FROM orders WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($data)) {
            return null;
        }
        return new self($data['id'], $data['telephone'], $data['city'], $data['street'], $data['house'], $data['comments'], );
    }
    public function getCity(): string
    {
        return $this->city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getHouse(): string
    {
        return $this->house;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getComments(): string
    {
        return $this->comments;
    }
}