<?php

namespace Service\Authentication;

use Model\User;

class SessionAuthenticationService implements AuthenticationInterface
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
        session_start();
        $_SESSION['user_id'] = $requestData->getId();

        return true;

    }
    public function getCurrentUser(): ?User
    {
        if (isset($this->user)) {
            return $this->user;
        }

        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            $user = User::getOneById($userId);

            $this->user = $user;

            return $user;
        } else {
            return null;
        }
    }
}