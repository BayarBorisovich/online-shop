<?php

use Container\Container;
use Controller\CartController;
use Controller\IndexController;
use Controller\OrderController;
use Controller\UserController;
use Service\Authentication\AuthenticationInterface;

return [
    UserController::class => function (Container $container) {
        $authenticationService = $container->get(AuthenticationInterface::class);

        return new UserController($authenticationService);
    },
    CartController::class => function (Container $container) {
        $authenticationService = $container->get(AuthenticationInterface::class);

        return new CartController($authenticationService);
    },
    IndexController::class => function (Container $container) {
        $authenticationService = $container->get(AuthenticationInterface::class);

        return new IndexController($authenticationService);
    },
    OrderController::class => function (Container $container) {
        $orderService = new \Service\OrderService();
        $authenticationService = $container->get(AuthenticationInterface::class);

        return new OrderController($orderService, $authenticationService);
    },
    AuthenticationInterface::class => function () {
        return new \Service\Authentication\SessionAuthenticationService();
    }
];