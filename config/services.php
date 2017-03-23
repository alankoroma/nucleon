<?php

use App\Application;
use App\Controller;
use App\Infrastructure;
use App\Infrastructure\Database\DatabaseDriver;

return [

    /* Debug Mode */
    'debug_mode' => function($c) {
        return $c['settings']['displayErrorDetails'];
    },

    /* Core */
    'view' => function($c) {
        return new Slim\Views\PhpRenderer($c['settings']['views']);
    },
    'db' => function($c) {

        $db_driver = new DatabaseDriver();
        $db_driver->setDriver(DB_DRIVER);

        if (DB_DRIVER == 'sqlite') {

            $db_driver->settings($c['settings']['db_attributes']);
            return $db_driver;

        } else if (DB_DRIVER == 'mysql') {

            $db_settings = array(
                'host' => DB_HOST,
                'user' => DB_USER,
                'password' => DB_PASS,
                'db_name' => DB_NAME
            );

            $db_driver->settings($db_settings);
            return $db_driver;
        }

    },
    /* Session */
    'session' => function($c) {
        return new App\Session\Session();
    },
    'session_storage' => function($c) {
        return new App\Infrastructure\Session\DbSessionStorage($c['db']);
    },
    'session_middleware' => function($c) {
        return new App\Middleware\UserSession(
            $c['session'],
            $c['session_storage'],
            'session_id'
        );
    },
    'auth_middleware' => function($c) {
        return new App\Middleware\Auth(
            $c['session'],
            $c['setup_user']
        );
    },
    'controller_factory' => function($c) {
        return new App\ControllerFactory(function($controller) use ($c) {
            $controller->setView($c['view']);
        });
    },

    /* Error Controller/Handlers */
   'notFoundHandler' => function($c) {
       return $c->controller_factory->create(
           Controller\ErrorController::class,
           404,
           $c['debug_mode']
       );
   },
   'errorHandler' => function($c) {
       return $c->controller_factory->create(
           Controller\ErrorController::class,
           500,
           $c['debug_mode']
       );
   },

    /* Index Controller */
    'index_controller' => function($c) {
        $controller = $c->controller_factory->create(
            Controller\IndexController::class
        );
        return $controller;
    }
];
