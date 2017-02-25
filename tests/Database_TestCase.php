<?php

abstract class Database_TestCase extends PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var PDO
     */
    protected static $dbh;

    /**
     * @var MySQLDriver
     */
    protected static $db_driver;

    public static function setUpBeforeClass()
    {
        self::$dbh = new PDO(TEST_DB_DSN, TEST_DB_USER, TEST_DB_PASS);

        self::$db_driver = new App\Infrastructure\Database\MySQLDriver(
            TEST_DB_HOST, TEST_DB_USER, TEST_DB_PASS, TEST_DB_NAME
        );
    }

    public static function tearDownAfterClass()
    {
        self::$dbh = null;
    }

    final public function getConnection()
    {
        return $this->createDefaultDBConnection(self::$dbh, TEST_DB_NAME);
    }

}
