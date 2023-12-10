<?php
namespace Request;
class LoginRequest extends Request
{
    public function validate(): array
    {
        $errors = [];
        if (isset($this->body['email'])) {
            $login = $this->body['email'];
            if (empty($login)) {
                $errors ['login'] = 'Заполните поле Login';
            } elseif (!strpos($login, '@')){
                $errors['login'] = "Некоректное заполнение поля Login, нет символа @";
            }
        } else {
            $errors = 'Заполните поле Login';
        }
        if (isset($this->body['psw'])) {
            $password = $this->body['psw'];
            if (empty($password)) {
                $errors['psw'] = 'Заполните поле password';
            }
        } else {
            $errors['psw'] = 'Заполните поле password';
        }
        return $errors;
    }
}