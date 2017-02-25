<?php

/* Load vendor and project libraries */
require(dirname(__FILE__) . '/vendor/autoload.php');

/* Debug Mode */
define('DEBUG_MODE', true);

if (DEBUG_MODE) {

  error_reporting(-1);
  ini_set('display_errors', 'On');

}

// Init dependency injection container
if (DEBUG_MODE) {

    $container_config = array_merge(
        require(__DIR__  . '/config/services.php')
    );

    unset($container_config['notFoundHandler']);
    unset($container_config['errorHandler']);

} else {

    $container_config = array_merge(
        require(__DIR__  . '/config/services.php')
    );
}
