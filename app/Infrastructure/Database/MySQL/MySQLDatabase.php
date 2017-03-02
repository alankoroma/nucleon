<?php

namespace App\Infrastructure\Database\MySQL;

use App\Infrastructure\Database\DatabaseInterface;
use Simplon\Mysql\Manager\SqlQueryBuilder;
use Simplon\Mysql\Manager\SqlManager;

class MySQLDatabase implements DatabaseInterface
{
    /**
    * @var MySQLDriver
    */
    protected $dbDriver;

    /**
    * Construct a new data access abstraction layer
    *
    * @param MySQLDriver $db_driver
    */
    function __construct(MySQLDriver $db_driver)
    {
        $this->dbDriver = $db_driver;
    }

    /**
     * Return last executed query
     *
     * @return string
     */
    public function getLastQuery()
    {
        return $this->dbDriver->lastQuery();
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
        $sql_builder = new SqlQueryBuilder();
        $sql_builder->setTableName($table)->setData($record);

        $sql_manager = new SqlManager($this->dbDriver);

        $response = $sql_manager->insert($sql_builder);

        return $response;
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
        $sql_builder = new SqlQueryBuilder();
        $sql_builder->setTableName($table)->setData($records);

        $sql_manager = new SqlManager($this->dbDriver);

        $response = $sql_manager->insert($sql_builder);

        return $response;
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
        $sql_builder = new SqlQueryBuilder();
        $sql_builder->setTableName($table)
            ->setConditions($conds)
            ->setData($record);

        $sql_manager = new SqlManager($this->dbDriver);

        $response = $sql_manager->update($sql_builder);

        return $response;
    }

    /**
    * Execute a query and return the generated statement/result set
    *
    * @param string $query Query string
    * @return \PDOStatement
    */
    public function query($query)
    {
        $sql_builder = new SqlQueryBuilder();
        $sql_builder->setQuery($query);

        $sql_manager = new SqlManager($this->dbDriver);

        $response = $sql_manager->executeSql($sql_builder);

        return $response;
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
        $sql_builder = new SqlQueryBuilder();
        $sql_builder->setQuery($query)->setConditions($conds);

        $sql_manager = new SqlManager($this->dbDriver);

        $result = $sql_manager->fetchRow($sql_builder);

        return $result;
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
        $sql_builder = new SqlQueryBuilder();
        $sql_builder->setQuery($query)->setConditions($conds);

        $sql_manager = new SqlManager($this->dbDriver);

        $results = $sql_manager->fetchRowMany($sql_builder);

        return $results;
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
        $sql_builder = new SqlQueryBuilder();
        $sql_builder->setTableName($table)->setConditions($conds);

        $sql_manager = new SqlManager($this->dbDriver);

        $response = $sql_manager->delete($sql_builder);

        return $response;
    }
}
