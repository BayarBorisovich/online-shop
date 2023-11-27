<?php

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'POST') {
    function validate(array $data)
    {
        $errors = [];
        if (isset($data['name'])) {
            $name = $data['name'];
            if (empty($name)) {
                $errors['name'] = 'Введите Name';
            } elseif (strlen($name) < 4) {
                $errors['name'] = 'Поле Name имеет менее 4 символов';
            }
        } else {
            $errors['name'] = 'Введите Name';
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (empty($email)) {
                $errors['email'] = 'Введите email';
            } elseif (strlen($email) < 4) {
                $errors['email'] = 'Поле email имеет менее 4 символов';
            } elseif (!strpos($email, '@')) {
                $errors['email'] = "Некоректное заполнение поля email, нет символа @";
            }
        } else {
            $errors['email'] = 'Введите email';
        }

        if (isset($data['psw'])) {
            $password = $data['psw'];
            if (empty($password)) {
                $errors['psw'] = 'Введите поле password';
            } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{4,30}$/', $password)) {
                $errors['psw'] = 'password должен состоять из букв (латиница) и цифр, иметь хотябы одну букву или цифру верхнего регистра';
            }
        } else {
            $errors['psw'] = 'Введите поле password';
        }

        if (isset($data['psw-repeat'])) {
            $repeatPassword = $data['psw-repeat'];
            if (empty($repeatPassword)) {
                $errors['psw-repeat'] = 'Введите поле Repeat Password';
            } elseif ($repeatPassword !== $password) {
                $errors['psw'] = 'Пароли не совподают';
            }
        } else {
            $errors['psw-repeat'] = 'Введите поле repeat password';
        }
        return $errors;
    }
    $errors = validate($_POST);

    if (empty($errors)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['psw'];
        $repeatPassword = $_POST['psw-repeat'];

        $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = $pdo->prepare(query: 'INSERT INTO users ( name, email, password) VALUES (:name, :email, :password)');
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
        $stmt = $pdo->prepare(query: 'SELECT * FROM users WHERE name = :name');
        $stmt->execute(['name' => $name]);
        $data = $stmt->fetch();
        header("location: /login");
    }
}
require_once './html/registrate.phtml';