<?php
require_once '../Model/ConnectingToTheDatabase.php';
class Product extends ConnectingToTheDatabase
{
    public function getAll (): array|false
    {
        $stmt = $this->PDO->query('SELECT * FROM products');
        return $stmt->fetchAll();
    }

}