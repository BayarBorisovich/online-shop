<?php
namespace Request;
class LoginRequest extends Request
{
    public function validate(): array
    {
        $errors = [];
        $data = $this->body;

        if (isset($data['email'])) {
            $login = $data['email'];
            if (empty($login)) {
                $errors ['login']= 'Заполните поле Login';
            } elseif (!strpos($login, '@')){
                $errors['login']= "Некоректное заполнение поля Login, нет символа @";
            }
        } else {
            $errors ['login'] = 'Заполните поле Login';
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
