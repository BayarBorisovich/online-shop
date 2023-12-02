<?php

class UserController
{
    public function registration($data): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestMethod === 'POST') {

            $errors = $this->validateRegistration($data);
            if (empty($errors)) {
                $name = $data['name'];
                $email = $data['email'];
                $password = $data['psw'];
                $repeatPassword = $data['psw-repeat'];

                require_once '../Model/User.php';

                $userModel = new User();
                $userModel->create($name, $email, $password);

                $requestData = $userModel->addOneByName($name);

                header("location: /login");
            }
        }
        require_once '../View/registration.phtml';

    }
    private function validateRegistration($data): array
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

    public function login($data): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if ($requestMethod === 'POST') {

            $errors = $this->validateLogin ($data);

            if (empty($errors)) {
                $login = $data['email'];
                $password = $data['psw'];

                require_once '../Model/User.php';

                $userModel = new User();
                $requestData = $userModel->addOneByEmail($login);

                if (!empty($requestData)) {
                    if ($password === $requestData['password']) {
                        session_start();
                        $_SESSION['user_id'] = $requestData['id'];
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
    private function validateLogin(array $data): array
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