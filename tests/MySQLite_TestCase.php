<?php

abstract class MySQLite_TestCase extends PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var PDO
     */
    protected static $dbh;

    /**
     * @var MySQLDriver
     */
    protected static $db_driver;

    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;

    public static function setUpBeforeClass()
    {
        $db_attributes = array(
            'driver' => DB_DRIVER,
            'filename' => __DIR__ . '/../db/test_nucleon.db'
        );

        self::$pdo = new PDO('sqlite::memory:');

        self::$db_driver = new PicoDb\Database($db_attributes);

        self::$dbh = new App\Infrastructure\Database\SQLite\SQLiteDatabase(
            self::$db_driver
        );

    }

    public static function tearDownAfterClass()
    {
        self::$pdo = null;
    }

    final public function getConnection()
    {
        if ($this->conn === null) {

            if (self::$pdo == null) {
                self::$pdo = new PDO('sqlite::memory:');
            }

            $this->conn = $this->createDefaultDBConnection(self::$pdo, ':memory:');
        }

        return $this->conn;
    }
}
