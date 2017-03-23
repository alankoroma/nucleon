<?php

namespace App\Infrastructure\Session;

use App\Session\Session;
use App\Infrastructure\Database\DatabaseDriver;

class SessionRepositoryTest extends \Database_TestCase
{
    public function getDataSet()
    {
        return $this->createXmlDataSet(__DIR__ . '/SessionData.xml');
    }

    public function setUp()
    {
        $this->db = self::$db;

        $this->sessionStorage = new DbSessionStorage(
            $this->db
        );

        parent::setUp();
    }

    public function tearDown()
    {
        $this->db = null;
    }

    public function testRead()
    {
        $session = $this->sessionStorage->read(
            '1cfa9b04-d293-11e6-9818-5217803caeb1'
        );

        $this->assertEquals('some data', $session->data());
    }

    public function testRemove()
    {
        $data = array();
        $session = new Session($data);

        $this->sessionStorage->remove(
            '1cfa9b04-d293-11e6-9818-5217803caeb1',
            $session
        );

        $session = $this->sessionStorage->read(
            '1cfa9b04-d293-11e6-9818-5217803caeb1'
        );

        $this->assertEmpty($session->data());
    }

}
