<?php
require_once '../Model/Model.php';
class Product extends Model
{
    public function getAll (): array|false
    {
        $stmt = $this->PDO->query('SELECT * FROM products');
        return $stmt->fetchAll();
    }

}