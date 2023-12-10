<?php
namespace Controller;
use Model\User;
use Request\LoginRequest;
use Request\RegistrationRequest;

class UserController
{
    public function getRegistration(): void
    {
        require_once '../View/registration.phtml';
    }


    public function postRegistration(RegistrationRequest $request): void
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $name = $request->getBody()['name'];
            $email = $request->getBody()['email'];
            $password = $request->getBody()['psw'];
            $repeatPassword = $request->getBody()['psw-repeat'];

            User::create($name, $email, $password);

            $requestData = User::addOneByName($name);

            header("location: /login");
        }
        require_once '../View/registration.phtml';
    }



    public function getLogin(): void
    {
        require_once '../View/login.phtml';
    }


    public function postLogin(LoginRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $login = $request->getBody()['email'];
            $password = $request->getBody()['psw'];

            $requestData = User::addOneByEmail($login);
            if (!empty($requestData)) {
                if ($password === $requestData->getPassword()) {
                    session_start();
                    $_SESSION['user_id'] = $requestData->getId();
                    header('location: /main');
                } else {
                    $errors['login'] = 'логин или пароль введены не верно';
                }
            } else {
                $errors['login'] = 'логин или пароль введены не верно';
            }
        }
        require_once '../View/login.phtml';
    }
}