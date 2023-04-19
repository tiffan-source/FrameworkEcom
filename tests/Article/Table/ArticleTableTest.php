<?php

namespace Tests\Article\Table;

use Tests\DatabaseTestCase;
use App\Article\Entity\Article;
use App\Article\Tables\ArticleTable;
use Framework\Exceptions\NoRecordException;

class ArticleTableTest extends DatabaseTestCase{

    private $articleTable;

    public function setUp():void{
        parent::setUp();
        $this->articleTable = new ArticleTable($this->pdo);
    }


    public function testFindIndexNotRecord() 
    {
        $this->expectException(NoRecordException::class);
        $article = $this->articleTable->find(10000);
    }

    // public function testCreate(){
    //     $this->articleTable->create([
    //         'name' => 'Abel',
    //         'description' => 'Un con',
    //         'quantity' => 100
    //     ]);

    //     $result = $this->articleTable->find(1);

    //     $this->assertEquals('Abel', $result->name);
    // }

    public function testFind() 
    {
        $this->seedDatabase();
        $article = $this->articleTable->find(10);
        $this->assertInstanceOf(Article::class, $article);
    }

    public function testUpdate(){
        $this->seedDatabase();
        $this->articleTable->update(12, ['name' => 'Salut']);
        $result = $this->articleTable->find(12);

        $this->assertEquals('Salut', $result->name);
    }

    public function testdelete()
    {
        $this->expectException(NoRecordException::class);
        $this->articleTable->delete(1);
        $article = $this->articleTable->find(1);
    }
}