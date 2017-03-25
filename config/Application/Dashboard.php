<?php

return [
    /* Controllers */
    'dashboard_controller' => function($c) {
        $controller = $c['controller_factory']->create(
            App\Controller\Dashboard\DashboardController::class
        );
        return $controller;
    },
];
