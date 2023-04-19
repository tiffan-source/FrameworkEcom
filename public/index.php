<?php
require dirname(__DIR__) . '/vendor/autoload.php';

use Framework\App;
use Twig\Environment;
use Middlewares\Whoops;
use DI\ContainerBuilder;
use App\Admin\AdminModule;
use App\Article\ArticleModule;
use Twig\Loader\FilesystemLoader;
use GuzzleHttp\Psr7\ServerRequest;
use Framework\Renderer\TwigRenderer;
use Framework\Middleware\CSRFMiddleware;
use Framework\Middleware\RouterMiddleware;
use Framework\Middleware\MethodeMiddleware;
use Framework\Middleware\NotFoundMiddleware;
use Framework\Middleware\DispatcherMiddleware;
use Framework\Middleware\TrailingSlashMiddleware;

$modules = [
    AdminModule::class, 
    ArticleModule::class,
];


$app = (new App(dirname(__DIR__) . '/config/config.php'))
    ->addModule(AdminModule::class)
    ->addModule(ArticleModule::class)
    ->pipe(Whoops::class)
    ->pipe(TrailingSlashMiddleware::class)
    ->pipe(MethodeMiddleware::class)
    ->pipe(CSRFMiddleware::class)
    ->pipe(RouterMiddleware::class)
    ->pipe(DispatcherMiddleware::class)
    ->pipe(NotFoundMiddleware::class);

if(php_sapi_name() !== 'cli'){
    $response = $app->run(ServerRequest::fromGlobals());

    \Http\Response\send($response);
}