<?php

namespace Tests\Framework\Database;

use PDO;
use stdClass;
use ReflectionClass;
use Framework\Database\Table;
use PHPUnit\Framework\TestCase;
use Framework\Exceptions\NoRecordException;

class TableTest extends TestCase
{
    private $table;

    public function setUp():void
    {
        $pdo = new PDO('sqlite::memory:', null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);

        $pdo->exec('CREATE TABLE test(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255)
        )');

        $this->table = new Table($pdo);
        $reflection = new ReflectionClass($this->table);
        $property = $reflection->getProperty('table');
        $property->setAccessible(true);
        $property->setValue($this->table, 'test');
    }

    public function testFind()
    {
        $this->table->getPDO()->exec('INSERT INTO test VALUES (1, "test1")');
        $this->table->getPDO()->exec('INSERT INTO test VALUES (2, "test2")');

        $data = $this->table->find(1);

        $this->assertInstanceOf(stdClass::class, $data);
        $this->assertEquals("test1", $data->name);
    }


    public function testFindList()
    {
        $this->table->getPDO()->exec('INSERT INTO test VALUES (1, "test1")');
        $this->table->getPDO()->exec('INSERT INTO test VALUES (2, "test2")');

        $data = $this->table->findList();

        $this->assertEquals([
            '1' => 'test1',
            '2' => 'test2',
        ], $data);
    }

    public function testExist()
    {
        $this->expectException(NoRecordException::class);

        $this->table->getPDO()->exec('INSERT INTO test VALUES (2, "test2")');
        $this->table->find(1);
    }

    public function testFindAll()
    {
        $this->table->getPDO()->exec('INSERT INTO test VALUES (1, "test1")');
        $this->table->getPDO()->exec('INSERT INTO test VALUES (2, "test2")');

        $data = $this->table->findAll();

        $this->assertCount(2, $data);
        $this->assertEquals('test1', $data[0]->name);
        $this->assertEquals('test2', $data[1]->name);
    }


    public function testFindBy()
    {
        $this->table->getPDO()->exec('INSERT INTO test VALUES (7, "test7")');
        $this->table->getPDO()->exec('INSERT INTO test VALUES (8, "test8")');

        $data = $this->table->findBy('name', 'test7');

        $this->assertInstanceOf(stdClass::class, $data);
        $this->assertEquals('test7', $data->name);
    }


    public function testCount()
    {
        $this->table->getPDO()->exec('INSERT INTO test VALUES (7, "test7")');
        $this->table->getPDO()->exec('INSERT INTO test VALUES (8, "test8")');
        $this->table->getPDO()->exec('INSERT INTO test VALUES (9, "test9")');

        $data = $this->table->count();

        $this->assertEquals(3, $data);
    }
}