<?php

namespace Tests\Framework\Middleware;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;
use Framework\Middleware\MethodeMiddleware;


class MethodeMiddlewareTest extends TestCase{
    
    private $middleware;

    public function setUp():void
    {
        $this->middleware = new MethodeMiddleware();
    }

    public function testMethodDeleteSet()
    {
        $request = (new ServerRequest('GET', '/'))
        ->withParsedBody(['_METHOD' => 'DELETE']);

        call_user_func_array($this->middleware, [
            $request, function(ServerRequest $request){
                $this->assertEquals('DELETE', $request->getMethod());
        }]);

    }
}