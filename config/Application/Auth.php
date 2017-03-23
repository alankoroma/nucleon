<?php

use App\Application;
use App\Controller;
use App\Infrastructure;

return [

    /*  Repository */
    'user_repository' => function($c) {
        return new App\Infrastructure\Domain\Users\DbUserRepository($c['db']);
    },

    /* Application Services */
    'log_in' => function($c) {
        return new App\Application\Auth\LogIn\LogIn(
            $c['user_repository'],
            $c['session']
        );
    },
    'log_out' => function($c) {
        return new App\Application\Auth\LogOut\LogOut(
            $c['session'],
            $c['user_repository']
        );
    },

    /* Forms */
    'log_in_from' => function($c) {
        return new App\Form\Auth\LogInForm();
    },

    /* Controllers */
    'login_controller' => function($c) {
        $controller = $c['controller_factory']->create(
            Controller\Auth\LoginController::class,
            $c['log_in'],
            $c['log_in_from']
        );
        return $controller;
    },
    'logout_controller' => function($c) {
        $controller = $c['controller_factory']->create(
            Controller\Auth\LogoutController::class,
            $c['log_out']
        );
        return $controller;
    },
];
