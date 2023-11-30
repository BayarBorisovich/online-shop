<?php

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'POST') {

    if (isset($_POST['product_id']) || isset($_POST['quantity'])) {
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

            $stmt = $pdo->prepare(query: 'SELECT * FROM carts WHERE user_id = :userId');
            $stmt->execute(['userId' => $userId]);
            $cart = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($cart)) {
                $stmt = $pdo->prepare(query: 'INSERT INTO carts ( name, user_id) VALUES (:name, :id)');
                $stmt->execute(['name' => 'cart1', 'id' => $userId]);

                $stmt = $pdo->prepare(query: 'SELECT * FROM carts WHERE user_id = :userId');
                $stmt->execute(['userId' => $userId]);
                $cart = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            $cartId = $cart['id'];
            $stmt = $pdo->prepare(query: 'INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)');
            $stmt->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
            header('location: /main');
        }
    }
} else {
    header('location: /login');
}


require_once './handler/main.php';