<?php

namespace App\Infrastructure\Session;

use App\Infrastructure\Database\DatabaseDriver;
use App\Session\SessionStorage;
use App\Session\Session;

class DbSessionStorage implements SessionStorage
{
    /**
    * @var DatabaseDriver
    */
    private $db;

    /**
    * Creates a new User repository Constructor
    *
    * @param DatabaseDriver $db
    */
    function __construct(DatabaseDriver $db)
    {
        $this->db = $db->getDatabase();
    }

    public function write($session_id, Session $session)
    {
        $this->db->delete(
            'sessions',
            array(
                'id' => $session_id
            )
        );

        $this->db->insert('sessions',
            array(
                'id' => $session_id,
                'data' => serialize($session->data())
            )
        );
    }

    public function read($session_id)
    {
        $data = $this->db->queryFirst('
            SELECT  *
            FROM    sessions
            WHERE   id = :id
            ', array(':id' => $session_id)
        );

        if (!$data) {
            $data = ['data' => 'a:0:{}'];
        }

        return new Session(unserialize($data['data']));
    }

    public function remove($session_id)
    {
        $this->db->delete(
            'sessions',
            array(
                'id' => $session_id
            )
        );
    }
}
