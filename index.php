<?php

// Bootstrap
require(dirname(__FILE__) . '/bootstrap.php');

if(DEBUG_MODE){
  error_reporting(-1);
  ini_set('display_errors', 'On');
}

/* Load vendor and project libraries */
require(dirname(__FILE__) . '/vendor/autoload.php');

/* Create an instance of the application with the provided configurations */
$app = App\AppFactory::create(
    require(__DIR__ . '/config/settings.php'),
    $container_config,
    require(__DIR__ . '/config/routes.php')
);

/* Handle the request */
$app->run();
