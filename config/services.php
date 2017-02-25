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
        return new PicoDb\Database($c['settings']['db_attributes']);
    },
    'controller_factory' => function($c) {
        return new App\ControllerFactory(function($controller) use ($c) {
            $controller->setView($c->view);
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
