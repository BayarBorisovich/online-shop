<?php
require_once '../Model/Model.php';
class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(int $id, string $name, string $email, string $password)
    {

        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function create(string $name, string $email,string $password): array|bool
    {
        $stmt = $this->PDO->prepare(query: 'INSERT INTO users ( name, email, password) VALUES (:name, :email, :password)');
        return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public static function addOneByName( $name): User
    {
        parent::getPdo1();
        $stmt = parent::$PDO1->prepare(query: 'SELECT * FROM users WHERE name = :name');
        $stmt->execute(['name' => $name]);
        $data = $stmt->fetch();
        return new self($data['id'], $data['name'], $data['email'], $data['password']);
    }

    public static function addOneByEmail( $login): User
    {
        parent::getPdo1();
        $stmt = parent::$PDO1->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute(['email' => $login]);
        $data = $stmt->fetch();
        return new self($data['id'], $data['name'], $data['email'], $data['password']);

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

}