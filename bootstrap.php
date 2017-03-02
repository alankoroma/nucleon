<?php

/* Load vendor and project libraries */
require(dirname(__FILE__) . '/vendor/autoload.php');

/* Load .env File */
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

/* Debug Mode */
if (getenv('DEBUG_MODE') == 'true') {
    define('DEBUG_MODE', true);
} else {
    define('DEBUG_MODE', false);
}

if (DEBUG_MODE) {
  error_reporting(-1);
  ini_set('display_errors', 'On');
}

/* Timezone */
if (getenv('TIME_ZONE') == null) {
    define('TIME_ZONE', 'UTC');
    date_default_timezone_set(TIME_ZONE);
} else {
    define('TIME_ZONE', getenv('TIME_ZONE'));
    date_default_timezone_set(TIME_ZONE);
}


/* Database Drivers */
$dotenv->required('DB_DRIVER')->allowedValues(['sqlite', 'mysql']);
define('DB_DRIVER', getenv('DB_DRIVER'));

/* MYSQL Database Settings */
if (DB_DRIVER == 'mysql') {

    $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);

    define('DB_HOST', getenv('DB_HOST'));
    define('DB_NAME', getenv('DB_NAME'));
    define('DB_USER', getenv('DB_USER'));
    define('DB_PASS', getenv('DB_PASS'));
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
