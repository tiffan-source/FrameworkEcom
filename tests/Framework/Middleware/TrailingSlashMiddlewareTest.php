<?php

namespace Tests\Framework\Middleware;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Framework\Middleware\TrailingSlashMiddleware;

class TrailingSlashMiddlewareTest extends TestCase {

    private $middleware;

    public function setUp():void
    {
        $this->middleware = new TrailingSlashMiddleware();
    }

    // public function testNoTrailingSlashAtEnd(){
    //     $request = new ServerRequest('GET', '/demo/');
        
    //     $handler = $this->getMockBuilder(RequestHandlerInterface::class)
    //     ->setMethods(['handle'])
    //     ->getMock();

    //     $response = $this->middleware->process($request, $handler);
    
    //     $this->assertEquals(301, $response->getStatusCode());
    //     $this->assertContains('/demo', $response->getHeader('Location'));
    // }
}