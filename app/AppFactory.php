<?php

namespace App;

use Slim\App;
/**
 * Application factory.
 *
 * Responsible for constructing instances of the application
 * with varying configurations.
 */
class AppFactory
{
    /**
     * Creates a new application using the provided settings,
     * services and routes configurations.
     *
     * @param  array $settings
     * @param  array $services
     * @param  array $routes
     * @return AppFactory
     */
    public static function create(
        array $settings,
        array $services,
        array $routes
    ) {

        $services['settings'] = $settings;

        $app = new App($services);

        foreach ($routes as $name => $route) {
            $map = call_user_func([$app, $route[0]], $route[1], $route[2]);
            $map->setName($name);
        }

        return $app;
    }
}
