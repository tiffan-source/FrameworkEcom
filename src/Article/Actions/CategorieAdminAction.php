<?php

namespace App\Article\Actions;

use Framework\Router;   
use Framework\Actions\CrudAction;
use Framework\Validator\Validator;
use Framework\Session\FlashService;
use App\Article\Tables\CategorieTable;
use Framework\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;


class CategorieAdminAction extends CrudAction {

    protected $viewPath = '@article/admin/categorie';
    protected $routePrefix = 'admin.categorie';

    public function __construct(
        RendererInterface $renderer,
        CategorieTable $table,
        Router $router,
        FlashService $flash){
        parent::__construct($renderer, $table, $router, $flash);
    }

    protected function getParams(ServerRequestInterface $request) : array
    {
        return array_filter($request->getParsedBody(), function($key){
            return in_array($key, ['name']);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function getValidator(ServerRequestInterface $request) : Validator
    {
        return parent::getValidator($request)
        ->required('name')
        ->slug('name')
        ->length('name', 2, 23)
        ->notEmpty('name');
    }
}