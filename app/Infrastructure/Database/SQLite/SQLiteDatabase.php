<?php

namespace App\Infrastructure\Database\SQLite;

use App\Infrastructure\Database\DatabaseInterface;
use PicoDb\Database;

class SQLiteDatabase implements DatabaseInterface
{
    /**
    * @var SQLite
    */
    protected $db;

    /**
    * Construct a new data access abstraction layer
    *
    * @param MySQLDriver $db_driver
    */
    function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Return last executed query
     *
     * @return string
     */
    public function getLastQuery()
    {
        return $this->db->getStatementHandler()->withLogging();
    }

    /**
    * Insert a record into the specified table
    *
    * @param string $table Table name
    * @param array $record Record as an array mapping column to value
    * @return bool Whether or not the operation was successful
    */
    public function insert($table, $record)
    {
        $this->db->table($table)->insert($record);
    }

    /**
    * Insert multiple records into the specified table
    *
    * @param string $table Table name
    * @param array $record Collection of records
    * @return array|bool Whether or not the operation was successful for each record
    */
    public function insertAll($table, $records)
    {

    }

    /**
    * Update a record in the specified table
    *
    * @param string $table Table name
    * @param array|string $conds Record as an array mapping column to value
    *                               or ID of record to be updated
    * @param array|string $record Array mapping updated columns to new values
    * @return bool Whether or not the operation was successful
    */
    public function update($table, $conds, $record)
    {

    }

    /**
    * Execute a query and return the generated statement/result set
    *
    * @param string $query Query string
    * @return \PDOStatement
    */
    public function query($query)
    {

    }

    /**
    * Execute a query and return the first result
    *
    * @param string $query Query string
    * @param array $conds Named query parameters
    * @return array()
    */
    public function queryFirst($query, $conds = array())
    {

    }

    /**
    * Execute a query and return all results
    *
    * @param string $query Query string
    * @param array $conds Named query parameters
    * @return array()
    */
    public function queryAll($query, $conds = array())
    {

    }

    /**
    * Delete a record from the specified table
    *
    * @param string $table Table name
    * @param array|string $conds array mapping column to value
    *                             or ID of record to be deleted
    * @return bool Whether or not the operation was successful
    */
    public function delete($table, $conds)
    {

    }
}
