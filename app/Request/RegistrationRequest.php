<?php

namespace Request;

class RegistrationRequest extends Request
{
    public function validate(): array
    {
        $errors = [];
        if (isset($this->body['name'])) {
            $name = $this->body['name'];
            if (empty($name)) {
                $errors['name'] = 'Введите Name';
            } elseif (strlen($name) < 4) {
                $errors['name'] = 'Поле Name имеет менее 4 символов';
            }
        } else {
            $errors['name'] = 'Введите Name';
        }

        if (isset($this->body['email'])) {
            $email = $this->body['email'];
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

        if (isset($this->body['psw'])) {
            $password = $this->body['psw'];
            if (empty($password)) {
                $errors['psw'] = 'Введите поле password';
            } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{4,30}$/', $password)) {
                $errors['psw'] = 'password должен состоять из букв (латиница) и цифр, иметь хотябы одну букву или цифру верхнего регистра';
            }
        } else {
            $errors['psw'] = 'Введите поле password';
        }

        if (isset($this->body['psw-repeat'])) {
            $repeatPassword = $this->body['psw-repeat'];
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
}