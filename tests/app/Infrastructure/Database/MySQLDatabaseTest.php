<?php

namespace App\Infrastructure\Database;

use Ramsey\Uuid\Uuid;
use App\Infrastructure\Database\MySQLDatabase;
use App\Domain\Authors\AuthorId;
use App\Domain\Authors\Author;

class MySQLDatabaseTest extends \Database_TestCase
{
    public function getDataSet()
    {
        return $this->createXmlDataSet(__DIR__ . '/AuthorData.xml');
    }

    public function setUp()
    {
        $this->db = new MySQLDatabase(self::$db_driver);

        parent::setUp();
    }

    public function tearDown()
    {
        $this->db = null;
    }

    public function testInsert()
    {
        $data = array(
            'id' => Uuid::uuid4()->toString(),
            'date_entered' => date('Y-m-d H:i:s'),
            'created_by' => '123456'
        );

        $this->assertEquals(3,
            $this->getConnection()->getRowCount('authors'),
            "Pre-Condition"
        );

        $this->db->insert('authors', $data);

        $this->assertEquals(4,
            $this->getConnection()->getRowCount('authors'),
            "Inserting failed"
        );
    }
}
