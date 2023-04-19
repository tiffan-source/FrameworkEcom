<?php

namespace Framework\Middleware;

use Framework\Router;
use Framework\Router\Route;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RouterMiddleware {

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $route = $this->container->get(Router::class)->match($request);

        if(is_null($route)){
            return $next($request);
        }

        $params = $route->getParameters();


        $request = array_reduce(array_keys($params), function ($request, $key) use ($params){
            return $request->withAttribute($key, $params[$key]);
        }, $request);

        $request = $request->withAttribute(Route::class, $route);

        return $next($request);
    }
}