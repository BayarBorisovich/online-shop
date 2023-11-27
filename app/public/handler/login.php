<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod === 'POST') {
     function validate($data) {
        $errors = [];
        if (isset($data['email'])) {
            $login = $data['email'];
            if (empty($login)) {
                $errors ['login'] = 'Заполните поле Login';
            } elseif (!strpos($login, '@')){
                $errors['login'] = "Некоректное заполнение поля Login, нет символа @";
            }
        } else {
            $errors = 'Заполните поле Login';
        }
        if (isset($data['psw'])) {
            $password = $data['psw'];
            if (empty($password)) {
                $errors['psw'] = 'Заполните поле password';
            }
        } else {
            $errors['psw'] = 'Заполните поле password';
        }
        return $errors;
    }
    $errors = validate($_POST);

    if (empty($errors)) {
        $login = $_POST['email'];
        $password = $_POST['psw'];

        $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute(['email' => $login]);
        $data = $stmt->fetch();

        if (!empty($data)) {
            if ($password === $data['password']) {
//                setcookie('login', $login, 0, "/");

               session_start();
               $_SESSION['user_id'] = $data['id'];
               header('location: /main');
            } else {
                $errors['login'] = 'логин или пароль введены не верно';
            }
        } else {
            $errors['login'] = 'логин или пароль введены не верно';
        }

    }
}
require_once './html/login.phtml';
