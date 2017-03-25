<?php

namespace App\Infrastructure\Database;

use App\Infrastructure\Database\DatabaseDriver;
use App\Infrastructure\Database\MySQL\MySQLDatabase;
use App\Infrastructure\Database\MySQL\MySQLDriver;
use App\Infrastructure\Database\SQLite\SQLiteDatabase;
use PicoDb\Database;

class DatabaseDriverTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->picoDb = $this->getMockBuilder(Database::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Test Setting A Database Driver
     */
    public function testSetDriver()
    {
        $this->driver = 'sqlite';
        $database_driver = new DatabaseDriver();
        $database_driver->setDriver($this->driver);

        $this->assertEquals('sqlite', $database_driver->dbDriver);
    }

    /**
     * Test Sqlite Database
     */
    public function testSqliteDatabse()
    {
        $this->driver = 'sqlite';
        $database_driver = new DatabaseDriver();
        $database_driver->setDriver($this->driver);

        $filename = './tests/db/test_nucleon.sqlite';

        $settings = array(
            'driver' => 'sqlite',
            'filename' => $filename
        );

        $database_driver->settings($settings);

        $db  = $database_driver->getDatabase();

        $this->assertAttributeInstanceOf(Database::class, 'db', $db);
    }

    /**
     * Test MySql Database
     */
    public function testMySqlDatabse()
    {
        $this->driver = 'mysql';
        $database_driver = new DatabaseDriver();
        $database_driver->setDriver($this->driver);

        $db_settings = array(
            'host' => 'localhost',
            'user' => 'root',
            'password' => 'root',
            'db_name' => 'test_nucleon'
        );

        $database_driver->settings($db_settings);

        $db = $database_driver->getDatabase();

        $this->assertAttributeInstanceOf(MySQLDriver::class, 'dbDriver', $db);
    }
}
