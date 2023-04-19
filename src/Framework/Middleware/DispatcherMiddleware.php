<?php

namespace Framework\Middleware;

use Framework\Router;
use Framework\Router\Route;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DispatcherMiddleware {

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $route = $request->getAttribute(Route::class);

        if(is_null($route))
        {
            return $next($request);
        }

        $callback = $route->getCallback();

        $response = call_user_func_array($route->getCallback(), [$request]);

        if(is_string($response)){
            return new Response(200, [], $response);
        }else if($response instanceof ResponseInterface){
            return $response;
        }else
            throw new Exception();
    }
}