<?php
namespace Model;
use PDO;

class Order extends Model
{
    private int $id;
    private int $userId;
    private string $telephone;
    private string $city;
    private string $street;
    private string $house;
    private string $comments;
    public function __construct(int $id, int $userId, string $telephone, string $city, string $street, string $house, string $comments = null)
    {
        $this->id = $id;
        $this->userId=$userId;
        $this->telephone = $telephone;
        $this->city = $city;
        $this->street = $street;
        $this->house = $house;
        $this->comments = $comments;
    }
    public static function create(int $userId, string $telephone, string $city, string $street, string $house, string $comments,): bool
    {
        $stmt = self::getPDO()->prepare(query: 'INSERT INTO orders (user_id, telephone, city, street, house, comments) VALUES (:user_id, :telephone, :city, :street, :house, :comments)');
        return $stmt->execute(['user_id' => $userId, 'telephone' => $telephone, 'city' => $city, 'street' => $street, 'house' => $house, 'comments' => $comments]);
    }
    public static function getOne(int $userId): Order|null
    {
        $stmt = self::getPDO()->prepare(query: 'SELECT * FROM orders WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($datas as $elem) {
           $data = $elem;
        }
        if (empty($data)) {
            return null;
        }
        return new self($data['id'], $data['user_id'], $data['telephone'], $data['city'], $data['street'], $data['house'], $data['comments'], );
    }
    public static function removingAorder(int $cartProductId): array|null
    {
        $stmt = self::getPDO()->prepare(query: 'DELETE FROM orders WHERE id = :id');
        $stmt->execute([$cartProductId]);
        $data = $stmt->fetchAll();
        return $data;
    }
    public static function delete(int $orderId, int $user_id): bool
    {
        $stmt = self::getPDO()->prepare(query: 'DELETE FROM orders WHERE id = :order_id and user_id = :user_id');
        return $stmt->execute([$orderId, $user_id]);
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

    public function getUserId(): int
    {
        return $this->userId;
    }
}