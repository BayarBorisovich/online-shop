<?php
//session_start();
//if (isset($_SESSION['user_id'])) {
//    $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
//    $stmt = $pdo->query('SELECT * FROM products');
//    $products = $stmt->fetchAll();
//    echo 'Добро пожаловать в каталог Online-shop';
//} else {
//    header('location: /login.php');
//}
if (isset($_COOKIE['login'])) {
    $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll();
    echo 'Добро пожаловать в каталог Online-shop';
} else {
    header('location: /login.php');
}
?>


<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php foreach ($products as $product): ?>
            <div class="card text-center">
                <a href="#">
                    <div class="card-header">
                        Hit!
                    </div>
                    <img class="card-img-top" src=<?php echo $product['image_link'] ?> alt="Card image">
                    <div class="card-body">
                        <p class="card-text text-muted"><?php echo $product['name'] ?></p>
                        <a href="#"><h5 class="card-title"><?php echo $product['description'] ?></h5></a>
                        <div class="card-footer">
                            <?php echo $product['price']." р." ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<style>
    body {
        font-style: sans-serif;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 16rem;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        font-size: 13px;
        color: gray;
        background-color: white;
    }

    .text-muted {
        font-size: 11px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }
</style>