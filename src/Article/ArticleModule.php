<?php

namespace App\Article;

use Framework\Module;
use Framework\Router;
use Psr\Container\ContainerInterface;
use Framework\Renderer\RendererInterface;
use App\Article\Actions\ArticleShowAction;
use App\Article\Actions\ArticleAdminAction;
use App\Article\Actions\ArticleIndexAction;
use App\Article\Actions\CategorieShowAction;
use App\Article\Actions\CategorieAdminAction;


class ArticleModule extends Module{

    const MIGRATIONS = __DIR__ . '/db/migrations';
    const SEEDS = __DIR__ . '/db/seeds';
    const DEFINITIONS = __DIR__ . '/config.php';


    public function __construct(ContainerInterface $container){
        $container->get(RendererInterface::class)->addPath(__DIR__ . '/views', 'article');

        $router = $container->get(Router::class);

        $router->get('/article', [$container->get(ArticleIndexAction::class), 'index'], 'article.index');
        $router->get('/article/{title}-{id}',  [$container->get(ArticleShowAction::class), 'show'], 'article.show');
        $router->get('/article/categorie/{name}', [$container->get(CategorieShowAction::class), 'show'], 'categorie.show');

        if($container->has('admin.prefix')){
            $prefix = $container->get('admin.prefix');

            $router->crud("$prefix/article", ArticleAdminAction::class, 'admin.article', $container);
            $router->crud("$prefix/categorie", CategorieAdminAction::class, 'admin.categorie', $container);    
        }
    }
}