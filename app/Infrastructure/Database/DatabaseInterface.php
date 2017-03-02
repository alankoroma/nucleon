<?php

namespace App\Infrastructure\Database;

interface DatabaseInterface
{
    public function insert($table, $record);
    public function update($table, $conds, $record);
    public function queryFirst($query, $conds = array());
    public function queryAll($query, $conds = array());
    public function delete ($table, $conds);
}
