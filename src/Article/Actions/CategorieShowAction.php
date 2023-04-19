<?php

namespace App\Article\Actions;

use PDO;
use Framework\Router;
use GuzzleHttp\Psr7\Request;
use App\Article\Tables\ArticleTable;
use App\Article\Tables\CategorieTable;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class CategorieShowAction{

    private $renderer;
    private $table;
    private $articleTable;

    public function __construct(
        RendererInterface $renderer,
        CategorieTable $table,
        ArticleTable $articleTable){
        $this->renderer = $renderer;
        $this->table = $table;
        $this->articleTable = $articleTable;
    }

    public function show(ServerRequestInterface $request) {
        $page = $request->getQueryParams();

        $categorie = $this->table->findBy('name', $request->getAttribute('name'));

        $articles = $this->articleTable->findPaginatedPublicForCategorie(5, $page['p'] ?? 1, $categorie->id);

        $categories = $this->table->findAll();

        return $this->renderer->render('@article/index', compact('articles', 'categories', 'categorie'));

    }
}