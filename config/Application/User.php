<?php

return [

    /*  Repository */
    'user_repository' => function($c) {
        return new App\Infrastructure\Domain\User\DbUserRepository($c['db']);
    },

    /* Application Services */
    'setup_user' => function($c) {
        return new App\Application\User\SetupUser\SetupUser(
            $c['user_repository']
        );
    },
    'register_user' => function($c) {
        return new App\Application\User\RegisterUser\RegisterUser(
            $c['user_repository']
        );
    },
    'update_user' => function($c) {
        return new App\Application\User\UpdateUser\UpdateUser(
            $c['user_repository']
        );
    },

    /* Forms */
    'register_from' => function($c) {
        return new App\Form\User\RegisterForm();
    },
    'update_from' => function($c) {
        return new App\Form\User\UpdateForm();
    },

    /* Controllers */
    'register_user_controller' => function($c) {
        $controller = $c['controller_factory']->create(
            App\Controller\User\RegisterUserController::class,
            $c['register_user'],
            $c['register_from']
        );
        return $controller;
    },
    'update_user_controller' => function($c) {
        $controller = $c['controller_factory']->create(
            App\Controller\User\UpdateUserController::class,
            $c['update_user'],
            $c['update_from']
        );
        return $controller;
    },

];
