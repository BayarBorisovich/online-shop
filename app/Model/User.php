<?php
require_once '../Model/ConnectingToTheDatabase.php';
class User extends ConnectingToTheDatabase
{
    public function create(string $name, string $email,string $password): array|bool
    {
        $stmt = $this->PDO->prepare(query: 'INSERT INTO users ( name, email, password) VALUES (:name, :email, :password)');
        return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function addOneByName( $name): mixed
    {
        $stmt = $this->PDO->prepare(query: 'SELECT * FROM users WHERE name = :name');
        $stmt->execute(['name' => $name]);
        return $stmt->fetch();
    }

    public function addOneByEmail( $login): mixed
    {
        $stmt = $this->PDO->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute(['email' => $login]);
        return $stmt->fetch();
    }

}