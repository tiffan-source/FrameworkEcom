<?php

namespace Tests\Article\Actions;

use stdClass;
use Framework\Router;
use App\Article\Entity\Article;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;
use App\Article\Tables\ArticleTable;
use App\Article\Actions\ArticleAction;
use App\Article\Tables\CategorieTable;
use Framework\Renderer\RendererInterface;
use App\Article\Actions\ArticleShowAction;

class ArticleShowActionTest extends TestCase{
    
    private $renderer;
    private $action;
    private $table;
    private $router;

    public function makeArticle(int $id, string $name) : Article
    {
        $article = new Article();
        $article->id = $id;
        $article->name = $name;
        return $article;
    }
    
}