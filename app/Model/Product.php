<?php
namespace Model;
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

        if (empty($data)) {
            return null;
        }
        $arr = [];
        foreach ($data as $product) {
            $arr[] = new self($product['id'], $product['name'], $product['price'], $product['description'], $product['image_link']);
        }
        return $arr;
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