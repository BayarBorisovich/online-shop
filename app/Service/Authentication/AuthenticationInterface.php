<?php

namespace Service\Authentication;

use Model\User;

interface AuthenticationInterface
{
    public function login(string $login, string $password);

    public function getCurrentUser(): ?User;

}