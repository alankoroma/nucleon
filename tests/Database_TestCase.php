<?php

use App\Infrastructure\Database\MySQL\MySQLDatabase;
use App\Infrastructure\Database\SQLite\SQLiteDatabase;

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
        if (DB_DRIVER == 'mysql') {

            self::$pdo = new PDO(TEST_DB_DSN, TEST_DB_USER, TEST_DB_PASS);

            self::$db_driver = new App\Infrastructure\Database\MySQL\MySQLDriver(
                TEST_DB_HOST, TEST_DB_USER, TEST_DB_PASS, TEST_DB_NAME
            );

            self::$db = new MySQLDatabase(self::$db_driver);
        }

        if (DB_DRIVER == 'sqlite') {

            $db_attributes = array(
                'driver' => DB_DRIVER,
                'filename' => __DIR__ . '/../tests/db/test_nucleon.sqlite'
            );

            self::$pdo = new PDO('sqlite:' . $db_attributes['filename'] . '');

            self::$db_driver = new PicoDb\Database($db_attributes);

            self::$db =new SQLiteDatabase(self::$db_driver);
        }
    }

    public static function cleanUp($table_name)
    {
        if (DB_DRIVER == 'mysql') {
            self::$db->query('TRUNCATE ' . $table_name);
        }

        if (DB_DRIVER == 'sqlite') {
            self::$db->query('DELETE FROM ' . $table_name);
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
