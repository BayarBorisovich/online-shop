<?php

class User
{
    public function creat (string $name, string $email,string $password): array|false
    {
        $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

        $stmt = $pdo->prepare(query: 'INSERT INTO users ( name, email, password) VALUES (:name, :email, :password)');
        return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }
}