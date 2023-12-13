<?php
namespace Model;
class Order extends Model
{
    private string $name;
    private string $surname;
    private string $patronymic;
    private string $city;
    private string $street;
    private string $house;
    public function __construct(string $name, string $surname, string $patronymic, string $city, string $street, string $house)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->patronymic = $patronymic;
        $this->city = $city;
        $this->street = $street;
        $this->house = $house;
    }
    public static function creatOrders(string $name, string $surname, string $patronymic, string $city, string $street, string $house, int $userId): bool
    {
        $stmt = self::getPDO()->prepare(query: 'INSERT INTO orders (name, surname, patronymic, city, street, house, user_id) VALUES (:name, :surname, :patronymic, :city, :street, :house, :user_id)');
        return $stmt->execute(['name' => $name, 'surname' => $surname, 'patronymic' => $patronymic, 'city' => $city, 'street' => $street, 'house' => $house, 'user_id' => $userId]);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getPatronymic(): string
    {
        return $this->patronymic;
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
}