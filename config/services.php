<?php

use App\Application;
use App\Controller;
use App\Infrastructure;

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

        if (DB_DRIVER == 'sqlite') {

            $pico_db = new PicoDb\Database($c['settings']['db_attributes']);

            return new App\Infrastructure\Database\SQLite\SQLiteDatabase(
                $pico_db
            );

        } else if (DB_DRIVER == 'mysql') {

            $db_driver = new App\Infrastructure\Database\MySQL\MySQLDriver(
                DB_HOST, DB_USER, DB_PASS, DB_NAME
            );

            return new Infrastructure\Database\MySQLDatabase($db_driver);
        }

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
