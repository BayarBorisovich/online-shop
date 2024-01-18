<?php

namespace Service\Authentication;

use Model\User;

class CookieAuthenticationService implements AuthenticationInterface
{
    private User $user;
    public function login(string $login, string $password): bool
    {
        $requestData = User::getOneByEmail($login);

        if (empty($requestData)) {
            return false;
        }
        if (!password_verify($password, $requestData->getPassword())) {
            return false;
        }
        setcookie('user_id', $requestData->getId());

        return true;

    }
    public function getCurrentUser(): ?User
    {
        if (isset($this->user)) {
            return $this->user;
        }

        if (isset($_COOKIE['user_id'])) {
            $userId = $_COOKIE['user_id'];

            $user = User::getOneById($userId);

            $this->user = $user;

            return $user;
        } else {
            return null;
        }
    }
}