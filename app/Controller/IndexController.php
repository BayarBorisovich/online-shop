<?php
namespace Controller;
use Model\Product;
use Service\Authentication\AuthenticationInterface;
use Service\Authentication\SessionAuthenticationService;

class IndexController
{
    private AuthenticationInterface $authenticationService;
    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }
    public function getMain(): void
    {
        $user = $this->authenticationService->getCurrentUser();

        if (empty($user->getId())) {
            header('location: /login');
        }
            $products = Product::getAll();

        require_once '../View/main.phtml';
    }

}
