<?php

namespace App\Infrastructure\Database\MySQL;

use Simplon\Mysql\Mysql;

class MySQLDriver extends Mysql
{
    public function lastQuery()
    {
        return $this->getLastStatement();
    }
}
