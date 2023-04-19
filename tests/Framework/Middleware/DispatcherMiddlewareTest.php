<?php

namespace Tests\Framework\Middleware;

use Framework\Router;
use Framework\Router\Route;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Middleware\DispatcherMiddleware;

class DispatcherMiddlewareTest extends TestCase {

    public function setUp():void
    {
        $this->middleware = new DispatcherMiddleware();
    }

    public function testRouteFunctionIscallIsString()
    {
        $request = (new ServerRequest('GET', '/'))
        ->withAttribute(Route::class, new Route('test', function(){
            return 'CC';
        }, []));

        $response = call_user_func_array($this->middleware, [$request, function(){

        }]);

        $this->assertEquals('CC', $response->getBody());
    }

    public function testRouteFunctionIsNotCall()
    {
        $request = (new ServerRequest('GET', '/'))
        ->withAttribute(Route::class, null);

        $response = call_user_func_array($this->middleware, [$request, function(){
            return new Response(404, [], 'Erreur');
        }]);

        $this->assertEquals(404, $response->getStatusCode());
    }
}