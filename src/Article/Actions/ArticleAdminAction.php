<?php

namespace App\Article\Actions;

use Framework\Router;
use Framework\Actions\CrudAction;
use Framework\Validator\Validator;
use Framework\Session\FlashService;
use App\Article\Tables\ArticleTable;
use App\Article\Tables\CategorieTable;
use Framework\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;


class ArticleAdminAction extends CrudAction {

    protected $viewPath = '@article/admin/article';
    protected $routePrefix = 'admin.article';

    private $tableCategorie;

    public function __construct(
        RendererInterface $renderer,
        ArticleTable $table,
        Router $router,
        FlashService $flash,
        CategorieTable $tableCategorie){
        parent::__construct($renderer, $table, $router, $flash);
        $this->tableCategorie = $tableCategorie;
    }

    protected function sendDataToView(array $params) : array
    {
        $params['categories'] = $this->tableCategorie->findList();
        return $params;
    }

    protected function getParams(ServerRequestInterface $request) : array
    {
        var_dump($request->getUploadedFiles());die();
        return array_filter($request->getParsedBody(), function($key){
            return in_array($key, ['name', 'quantity', 'description', 'categorie_id']);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function getValidator(ServerRequestInterface $request) : Validator
    {
        return parent::getValidator($request)
        ->required('name', 'quantity', 'description', 'categorie_id')
        ->notEmpty('name', 'description', 'quantity')
        ->slug('name')
        ->length('name', 2, 23)
        ->exist('categorie_id', $this->tableCategorie);
    }
}