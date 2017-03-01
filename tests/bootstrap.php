<?php

// Load Vendor
require(dirname(dirname(__FILE__)) . '/vendor/autoload.php');

/* Load .env File */
$dotenv = new Dotenv\Dotenv(dirname(dirname(__FILE__)));
$dotenv->load();

/* Timezone */
if (getenv('TIME_ZONE') == null) {
    define('TIME_ZONE', 'UTC');
    date_default_timezone_set(TIME_ZONE);
} else {
    define('TIME_ZONE', getenv('TIME_ZONE'));
    date_default_timezone_set(TIME_ZONE);
}

require (dirname(__FILE__). '/Database_TestCase.php');

/* Database Drivers */
$dotenv->required('DB_DRIVER')->allowedValues(['sqlite', 'mysql']);
define('DB_DRIVER', getenv('DB_DRIVER'));

/* MYSQL Database Settings */
if (DB_DRIVER == 'mysql') {

    $dotenv->required(['TEST_DB_HOST', 'TEST_DB_NAME', 'TEST_DB_USER', 'TEST_DB_PASS']);

    define('TEST_DB_HOST', getenv('TEST_DB_HOST'));
    define('TEST_DB_NAME', getenv('TEST_DB_NAME'));
    define('TEST_DB_USER', getenv('TEST_DB_USER'));
    define('TEST_DB_PASS', getenv('TEST_DB_PASS'));

    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=utf8',
        TEST_DB_HOST,
        TEST_DB_NAME
    );

    define('TEST_DB_DSN', $dsn);
}
