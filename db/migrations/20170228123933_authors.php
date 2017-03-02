<?php

use Phinx\Migration\AbstractMigration;

class Authors extends AbstractMigration
{
    public function change()
    {
        $this->table('authors', array('id' => false, 'primary_key' => array('id')))
            ->addColumn('id', 'uuid', array('length'=>36,'default'=>''))
            ->addColumn('date_entered', 'datetime', array('default'=>'0000-00-00 00:00:00'))
            ->addColumn('date_modified', 'datetime', array('default'=>'0000-00-00 00:00:00'))
            ->addColumn('modified_user_id', 'uuid', array('length'=>36,'default'=>''))
            ->addColumn('created_by', 'uuid', array('length'=>36,'default'=>''))
            ->addColumn('author_first_name', 'string', array('length'=>30,'default'=>''))
            ->addColumn('author_last_name', 'string', array('length'=>30,'default'=>''))
            ->addColumn('author_picture', 'string', array('length'=>50))
            ->addColumn('deleted', 'datetime', array('default'=>null))
            ->create();
    }
}
