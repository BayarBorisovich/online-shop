<?php

class Product
{
    public function getAll (): array|false
    {
        $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

        $stmt = $pdo->query('SELECT * FROM products');
        return $stmt->fetchAll();
    }

}