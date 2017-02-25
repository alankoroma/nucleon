<?php

namespace App\Infrastructure\Database;

use Ramsey\Uuid\Uuid;
use App\Infrastructure\Database\MySQLDatabase;

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

    /**
     * Test Database Insert
     */
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

    /**
     * Test Database InsertAll
     */
    public function testInsertAll()
    {
        $data = array(
            array(
                'id' => Uuid::uuid4()->toString(),
                'date_entered' => date('Y-m-d H:i:s'),
                'created_by' => '123456'
            ),
            array(
                'id' => Uuid::uuid4()->toString(),
                'date_entered' => date('Y-m-d H:i:s'),
                'created_by' => '1234567'
            )
        );

        $this->assertEquals(3,
            $this->getConnection()->getRowCount('authors'),
            "Pre-Condition"
        );

        $this->db->insertAll('authors', $data);

        $this->assertEquals(5,
            $this->getConnection()->getRowCount('authors'),
            "Inserting failed"
        );
    }

    /**
     * Test Database Update
     */
    public function testUpdate()
    {
        $data = array(
            'id' => Uuid::uuid4()->toString(),
            'date_entered' => date('Y-m-d H:i:s'),
            'created_by' => '123456'
        );

        $id = '04acc367-33f7-11e5-a6b3-000c29d6482a';

        $this->assertEquals(3,
            $this->getConnection()->getRowCount('authors'),
            "Pre-Condition"
        );

        $this->db->update(
            'authors',
            array(
                'id' => $id
            ),
            $data
        );

        $this->assertEquals(3,
            $this->getConnection()->getRowCount('authors'),
            "Inserting failed"
        );
    }

    /**
     * Test Database Query
     */
    public function testQuery()
    {
        $this->assertEquals(3,
            $this->getConnection()->getRowCount('authors'),
            "Pre-Condition"
        );

        $query = 'TRUNCATE authors';
        $this->db->query($query);

        $this->assertEquals(0,
            $this->getConnection()->getRowCount('authors'),
            "Inserting failed"
        );
    }

    /**
     * Test Database QueryFirst
     */
    public function testQueryFirst()
    {
        $id = '04acc367-33f7-11e5-a6b3-000c29d6482a';

        $data = $this->db->queryFirst('
            SELECT *
            FROM authors
            WHERE id = :id',
            array(
                ':id' => $id
            )
        );

        $this->assertEquals('04acc367-33f7-11e5-a6b3-000c29d6482a', $data['id']);
    }

    /**
     * Test Database QueryAll
     */
    public function testQueryAll()
    {
        $this->assertEquals(3,
            $this->getConnection()->getRowCount('authors'),
            "Pre-Condition"
        );

        $author_name = 'Rowlings';

        $authors = $this->db->queryAll('
            SELECT *
            FROM authors
            WHERE deleted = 0 AND
            author_name = :author_name',
            array(
                ':author_name' => $author_name
            )
        );

        $authors_array = array();
        foreach ($authors as $author) {
            $authors_array[$author['id']] = $author;
        }

        $this->assertArrayHasKey('04acc367-33f7-11e5-a6b3-000c29d6482a', $authors_array);
        $this->assertArrayHasKey('f21e5998-b983-11e6-928f-3e0662d818ed', $authors_array);
        $this->assertArrayNotHasKey('3f4f593e-a94e-102d-a80b-182573d3c666', $authors_array);
    }

    /**
     * Test Database Delete
     */
    public function testDelete()
    {
        $id = '04acc367-33f7-11e5-a6b3-000c29d6482a';

        $this->assertEquals(3,
            $this->getConnection()->getRowCount('authors'),
            "Pre-Condition"
        );

        $this->db->delete(
            'authors',
            array(
                'id' => $id
            )
        );

        $this->assertEquals(2,
            $this->getConnection()->getRowCount('authors'),
            "Inserting failed"
        );
    }
}
