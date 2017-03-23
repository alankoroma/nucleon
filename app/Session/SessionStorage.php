<?php

namespace App\Session;

interface SessionStorage
{
    public function write($session_id, Session $session);
    public function read($session_id);
    public function remove($session_id);
}
