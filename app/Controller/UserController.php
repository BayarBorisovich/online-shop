<?php

class UserController
{
    public function registrate()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestMethod === 'POST') {

            $errors = $this->validateRegistrate ($_POST);
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
        require_once '../View/registrate.phtml';

    }
    private function validateRegistrate ($data): array
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

    public function login (): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if ($requestMethod === 'POST') {

            $errors = $this->validateLogin ($_POST);

            if (empty($errors)) {
                $login = $_POST['email'];
                $password = $_POST['psw'];

                $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
                $stmt->execute(['email' => $login]);
                $data = $stmt->fetch();

                if (!empty($data)) {
                    if ($password === $data['password']) {
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
        require_once '../View/login.phtml';
    }
    private function validateLogin (array $data): array
    {
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

}