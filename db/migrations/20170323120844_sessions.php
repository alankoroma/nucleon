<?php

use Phinx\Migration\AbstractMigration;

class Sessions extends AbstractMigration
{
    public function change()
    {
        $this->table('sessions', array('id' => false, 'primary_key' => 'id'))
            ->addColumn('id', 'uuid', array('length'=>36,'default'=>''))
            ->addColumn('data', 'string', array('length'=>250))
            ->create();
    }
}
