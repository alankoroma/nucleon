<?php

use App\Infrastructure\Database\MySQL\MySQLDatabase;
use App\Infrastructure\Database\SQLite\SQLiteDatabase;
use App\Infrastructure\Database\DatabaseDriver;

abstract class Database_TestCase extends PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var PDO
     */
    protected static $pdo;

    /**
     * @var Database Driver
     */
    protected static $db_driver;

    /**
     * @var Database
     */
    protected static $db;

    public static function setUpBeforeClass()
    {
        $database_driver = new DatabaseDriver();
        $database_driver->setDriver(DB_DRIVER);

        if (DB_DRIVER == 'sqlite') {

            $db_settings = array(
                'driver' => DB_DRIVER,
                'filename' => __DIR__ . '/../tests/db/test_nucleon.sqlite'
            );

            self::$pdo = new PDO('sqlite:' . $db_settings['filename'] . '');

            $database_driver->settings($db_settings);

            self::$db = $database_driver;

        } else if (DB_DRIVER == 'mysql') {

            self::$pdo = new PDO(TEST_DB_DSN, TEST_DB_USER, TEST_DB_PASS);

            $db_settings = array(
                'host' => TEST_DB_HOST,
                'user' => TEST_DB_USER,
                'password' => TEST_DB_PASS,
                'db_name' => TEST_DB_NAME
            );

            $database_driver->settings($db_settings);

            self::$db = $database_driver;
        }
    }

    public static function cleanUp($table_name)
    {
        $database = self::$db->getDatabase();

        if (DB_DRIVER == 'mysql') {
            $database->query('TRUNCATE ' . $table_name);
        }

        if (DB_DRIVER == 'sqlite') {
            $database->query('DELETE FROM ' . $table_name);
        }
    }

    public static function tearDownAfterClass()
    {
        self::$pdo = null;
    }

    final public function getConnection()
    {
        if (DB_DRIVER == 'mysql') {
            return $this->createDefaultDBConnection(self::$pdo, TEST_DB_NAME);
        }

        if (DB_DRIVER == 'sqlite') {
            $db_attributes = array(
                'driver' => DB_DRIVER,
                'filename' => __DIR__ . '/../tests/db/test_nucleon.sqlite'
            );

            if (null === self::$pdo) {
               self::$pdo = new PDO('sqlite:' . $db_attributes['filename'] . '');
            }

           return $this->createDefaultDBConnection(self::$pdo, $db_attributes['filename']);
        }

    }
}
