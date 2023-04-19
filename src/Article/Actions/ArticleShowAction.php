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

class ArticleShowAction{

    private $renderer;
    private $table;
    private $router;
    use RouterAwareAction;

    public function __construct(
        RendererInterface $renderer,
        ArticleTable $table, 
        Router $router){
        $this->renderer = $renderer;
        $this->table = $table;
        $this->router = $router;
    }

    public function show(ServerRequestInterface $request) {
        $title = $request->getAttribute('title');
        $id = $request->getAttribute('id');
        $article = $this->table->findWithCategorie($id);

        if($article->name !== $title){
            return $this->redirect('article.show', [
                'title' => $article->name,
                'id' =>$id
            ]);
        }

        return $this->renderer->render('@article/show', [
            'article' => $article
        ]);
    }
}