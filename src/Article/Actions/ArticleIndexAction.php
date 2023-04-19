<?php

namespace App\Article\Actions;

use PDO;
use Framework\Router;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use App\Article\Tables\ArticleTable;
use App\Article\Tables\CategorieTable;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class ArticleIndexAction{

    private $renderer;
    private $table;
    private $categorieTable;
    use RouterAwareAction;

    public function __construct(
        RendererInterface $renderer,
        ArticleTable $table, 
        CategorieTable $categorieTable){
        $this->renderer = $renderer;
        $this->table = $table;
        $this->categorieTable = $categorieTable;
    }

    public function index(ServerRequestInterface $request): string {
        $page = $request->getQueryParams();
        $articles = $this->table->findPaginatedQueryPublic(5, $page['p'] ?? 1);
        $categories = $this->categorieTable->findAll();
        return $this->renderer->render('@article/index', compact('articles', 'categories'));
    }

}