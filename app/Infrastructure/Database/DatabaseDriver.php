<?php

namespace App\Infrastructure\Database;

use App\Infrastructure\Database\MySQL\MySQLDatabase;
use App\Infrastructure\Database\MySQL\MySQLDriver;
use App\Infrastructure\Database\SQLite\SQLiteDatabase;
use PicoDb\Database;

class DatabaseDriver
{
    /**
     * @var string
     */
    protected $dbDriver;

    /**
     * @var array
     */
    private $settings;

    /**
     * Set Database Driver
     *
     * @param string $db_driver
     */
    public function setDriver($db_driver)
    {
        $this->dbDriver = $db_driver;
    }

    /**
     * Set Database Settings
     *
     * @param array $settings
     */
    public function settings(array $db_settings)
    {
        $this->settings = $db_settings;
    }

    /**
     * Returns a Database based on the driver
     */
    public function getDatabase()
    {
        if ($this->dbDriver == 'sqlite') {

            $pico_db = new Database($this->settings);

            return new SQLiteDatabase(
                $pico_db
            );

        } else if ($this->dbDriver == 'mysql') {

            $db_driver = new MySQLDriver(
                $this->settings['host'],
                $this->settings['user'],
                $this->settings['password'],
                $this->settings['db_name']
            );

            return new MySQLDatabase($db_driver);
        }
    }
}
