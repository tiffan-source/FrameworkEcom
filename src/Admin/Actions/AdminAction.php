<?php

namespace App\Admin\Actions;

use Framework\Router;
use Framework\Validator\Validator;
use Framework\Session\FlashService;
use App\Article\Tables\ArticleTable;
use Framework\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;


class AdminAction {

    private $renderer;
    private $table;
    private $router;
    private $flash;
    use RouterAwareAction;

    public function __construct(
        RendererInterface $renderer,
        $table,
        Router $router,
        FlashService $flash){
        $this->renderer = $renderer;
        $this->table = $table;
        $this->router = $router;
        $this->flash = $flash;
    }

    public function articleIndex(ServerRequestInterface $request): string {
        $page = $request->getQueryParams();
        $articles = $this->table->findPaginated(5, $page['p'] ?? 1);
        return $this->renderer->render('@admin/indexArticle', compact('articles'));
    }

    public function editArticle(ServerRequestInterface $request)
    {
        $item = $this->table->find($request->getAttribute('id'));

        if($request->getMethod() == 'POST'){
            $params = $this->getParams($request);

            $validator = $this->getValidator($request);
            if($validator->isValid())
            {
                $this->table->update($item->id, $params);
                $this->flash->success('L\'article a bien ete modifier');    
                return $this->redirect('admin.article.index');
            }
            $errors = $validator->getErrors();
        }

        return $this->renderer->render('@admin/editArticle', compact('item', 'errors'));
    }

    public function createArticle(ServerRequestInterface $request)
    {
        if($request->getMethod() == 'POST'){
            $params = $this->getParams($request);

            $validator = $this->getValidator($request);
            if($validator->isValid())
            {
                $this->table->create($params);
                $this->flash->success('Article creer');    
                return $this->redirect('admin.article.index');
            }
            $errors = $validator->getErrors();
        }

        return $this->renderer->render('@admin/createArticle', compact('item', 'errors'));
    }

    public function deleteArticle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = $request->getAttribute('id');
        $this->table->delete($id);
        return $this->redirect('admin.article.index');
    }

    private function getParams(ServerRequestInterface $request) : array
    {
        return array_filter($request->getParsedBody(), function($key){
            return in_array($key, ['name', 'quantity', 'description']);
        }, ARRAY_FILTER_USE_KEY);
    }

    private function getValidator(ServerRequestInterface $request) : Validator
    {
        return (new Validator($request->getParsedBody()))
        ->required('name', 'quantity', 'description')
        ->slug('name')
        ->length('name', 2, 23)
        ->notEmpty('name', 'description', 'quantity');
    }
}