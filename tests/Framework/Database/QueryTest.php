<?php
namespace Tests\Framework\Database;

use Tests\DatabaseTestCase;
use Framework\Database\Query;
use PHPUnit\Framework\TestCase;

class QueryTest extends DatabaseTestCase {

    protected $pdo;

    public function setUp():void
    {
        parent::setUp();
    }
    
    // public function testSimpleQuery()
    // {
    //     $query = (new Query())
    //     ->from('tests')
    //     ->select('name');

    //     $this->assertEquals('SELECT name FROM tests', (string)$query);
    // }

 
    // public function testSimpleQueryWithWhere()
    // {
    //     $query = (new Query())
    //     ->from('tests', 't')
    //     ->where('a = :a');

    //     $this->assertEquals('SELECT * FROM tests AS t WHERE (a = :a)', (string)$query);
    // }

     
    // public function testSimpleQueryWithWhereComplexe()
    // {
    //     $query = (new Query())
    //     ->from('tests', 't')
    //     ->where('a = :a')
    //     ->where('b = :a OR a = :a');

    //     $this->assertEquals('SELECT * FROM tests AS t WHERE (a = :a) AND (b = :a OR a = :a)', (string)$query);
    // }

    public function testFetchAll()
    {
        // $this->seedDatabase();

        // // $this->assertEquals(25, $posts);
        // $posts = (new Query($this->pdo))
        // ->from('articles', 'a')
        // // ->where('a.id < :number')
        // // ->params([
        // //     'number' => 7
        // // ])
        // ->count();

        // $this->assertEquals(9, $posts);
    }

    public function testHydrateEntity()
    {
        $this->seedDatabase();
        $posts = (new Query($this->pdo))
        ->from('articles', 'a')
        ->into(Demo::class)
        ->all();

        $this->assertEquals('demo', substr($posts[0]->getName(), -4));
    }
    
    public function testLazyHydrateEntity()
    {
        $this->seedDatabase();
        $posts = (new Query($this->pdo))
        ->from('articles', 'a')
        ->into(Demo::class)
        ->all();

        $post = $posts[0];
        $post2 = $posts[0];

        $this->assertSame($post, $post2);
    }
    
}