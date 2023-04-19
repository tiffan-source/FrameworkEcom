<?php

namespace Framework\Middleware;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class MethodeMiddleware {
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        if(
            array_key_exists('_METHOD', $request->getParsedBody() ?? [])
            &&
            in_array($request->getParsedBody()['_METHOD'], ['DELETE', 'PUT'])
        ){
            $request = $request->withMethod($request->getParsedBody()['_METHOD']);
        }

        return $next($request);
    }
}