<?php
namespace Model;
use PDO;

class Product extends Model
{
    private int $id;
    private string $name;
    private float $price;
    private string $description;
    private string $image_link;

    public function __construct(int $id, string $name, float $price, string $description, string $image_link)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->image_link = $image_link;
    }
    public static function getAll(): array
    {
        $stmt = self::getPDO()->query('SELECT * FROM products');
        $data = $stmt->fetchAll();
        $arr = [];
        foreach ($data as $product) {
            $arr[] = new self($product['id'], $product['name'], $product['price'], $product['description'], $product['image_link']);
        }
        return $arr;
    }
    public static function getAllByIds(array $ids): array|null
    {
        $result = [];
        foreach ($ids as $elem) {
            $elem = '?';
            $result[] = $elem;
        }
        $results = implode(', ', $result);
        $stmt = self::getPDO()->prepare( "SELECT * FROM products WHERE id IN ($results)");
        $stmt->execute($ids);
        $data = $stmt->fetchAll();
//        var_dump($data);die;
        if (empty($data)) {
            return null;
        }
        $arr = [];
        foreach ($data as $product) {
            $arr[] = new self($product['id'], $product['name'], $product['price'], $product['description'], $product['image_link']);
        }
        return $arr;
    }
    public static function getAllByUserId(int $userId): array|null
    {
        $stmt = self::getPDO()->prepare(query: 'SELECT p.* FROM products p INNER JOIN cart_products cp on p.id=cp.product_id INNER JOIN carts c on c.id=cp.cart_id WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($data)) {
            return null;
        }
        $arr = [];
        foreach ($data as $product) {
            $arr[$product['id']] = new self($product['id'], $product['name'], $product['price'], $product['description'], $product['image_link']);
        }

        return $arr;
//        try {
//            self::getPDO()->beginTransaction();
//            $stmt = self::getPDO()->prepare(query: 'SELECT p.* FROM products p INNER JOIN cart_products cp on p.id=cp.product_id INNER JOIN carts c on c.id=cp.cart_id WHERE user_id = :user_id');
//            $stmt->execute(['user_id' => $userId]);
//            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//            self::getPDO()->commit();
//
//        } catch (\PDOException $e) {
//            self::getPDO()->rollBack();
//            throw $e;
//        }
//
//        if (empty($data)) {
//            return null;
//        }
//        $arr = [];
//        foreach ($data as $product) {
//            $arr[] = new self($product['id'], $product['name'], $product['price'], $product['description'], $product['image_link']);
//        }
//        return $arr;

    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImageLink(): string
    {
        return $this->image_link;
    }


}