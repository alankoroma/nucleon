<?php

use Phinx\Migration\AbstractMigration;

class UsersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('users', array('id' => false, 'primary_key' => 'id'))
            ->addColumn('id', 'uuid', array('length'=>36,'default'=>''))
            ->addColumn('date_entered', 'datetime')
            ->addColumn('date_modified', 'datetime')
            ->addColumn('modified_user_id', 'uuid', array('length'=>36,'default'=>''))
            ->addColumn('created_by', 'uuid', array('length'=>36,'default'=>''))
            ->addColumn('admin', 'char', array('length'=>1,'default'=>''))
            ->addColumn('username', 'string', array('length'=>30,'default'=>''))
            ->addColumn('user_password', 'string', array('length'=>64,'default'=>''))
            ->addColumn('user_firstname', 'string', array('default'=>''))
            ->addColumn('user_lastname', 'string', array('default'=>''))
            ->addColumn('user_email', 'string', array('default'=>''))
            ->addColumn('user_phone', 'string', array('default'=>''))
            ->addColumn('user_picture', 'string', array('length'=>50))
            ->addColumn('last_login', 'datetime', array('null'=>true))
            ->addColumn('deleted', 'datetime', array('null'=>true))
            ->create();
    }
}
