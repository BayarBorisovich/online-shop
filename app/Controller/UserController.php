<?php
namespace Controller;
use Model\User;
use Request\LoginRequest;
use Request\RegistrationRequest;
use Service\Authentication\AuthenticationInterface;
use Service\Authentication\SessionAuthenticationService;

class UserController
{
    private AuthenticationInterface $authenticationService;
    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

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
            $hash = password_hash($password, PASSWORD_DEFAULT);

            User::create($name, $email, $hash);

            $requestData = User::getOneByName($name);

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

            $result = $this->authenticationService->login($login, $password);

            if ($result) {
                header('location: /main');
            }

            $errors['login'] = 'логин или пароль введены не верно';
        }
        require_once '../View/login.phtml';
    }
}
