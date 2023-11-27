<?php

session_start();
$productId = $_POST['product_id'];
$quantity = $_POST['quantity'];
//var_dump($_POST);
//die();
if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch();
        $stmt = $pdo->prepare(query: 'SELECT * FROM carts WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($cart)) {
            $name = $user['name'];
            $stmt = $pdo->prepare(query: 'INSERT INTO carts ( name, user_id) VALUES (:name, :id)');
            $stmt->execute(['name' => $name, 'id' => $userId]);
            $stmt = $pdo->prepare(query: 'SELECT * FROM carts WHERE user_id = :userId');
            $stmt->execute(['userId' => $userId]);
            $cart = $stmt->fetch(PDO::FETCH_ASSOC);
        }
            $cartId = $cart['id'];
            $stmt = $pdo->prepare(query: 'INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)');
            $stmt->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
}




require_once './html/addProduct.phtml';