<?php

namespace Framework\Middleware;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TrailingSlashMiddleware implements MiddlewareInterface {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $next) : ResponseInterface
    {
        $uri = $request->getUri()->getPath();

        if(!empty($uri) && $uri[-1] === '/'){
            $response = new Response();
            return $response->withStatus(301)->withHeader('Location', substr($uri, 0, -1));
        }

        return $next->handle($request);
    }
}