<?php

namespace Tests\Framework\Middleware;

use Exception;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Framework\Middleware\CSRFMiddleware;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CSRFMiddlewareTest extends TestCase {
    private $csrf;
    private $session;
 
    public function setUp():void{
        $this->session = [];
        $this->csrf = new CSRFMiddleware($this->session);
    }

    // public function testGetMethodPass()
    // {
    //     $delegate = $this->getMockBuilder(RequestHandlerInterface::class)
    //     ->setMethods(['handle'])
    //     ->getMock();

    //     $delegate->expects($this->once())
    //     ->method('handle');

    //     $request= new ServerRequest('GET', '/demo');

    //     $this->csrf->process($request, $delegate);
    // }


    // public function testPOSTMethodNoPassWithoutToken()
    // {
    //     $delegate = $this->getMockBuilder(RequestHandlerInterface::class)
    //     ->setMethods(['handle'])
    //     ->getMock();

    //     $delegate->expects($this->never())
    //     ->method('handle');

    //     $request= new ServerRequest('POST', '/demo');

    //     $this->expectException(Exception::class);

    //     $this->csrf->process($request, $delegate);
    // }


    // public function testPOSTMethodPassWithToken()
    // {
    //     $delegate = $this->getMockBuilder(RequestHandlerInterface::class)
    //     ->setMethods(['handle'])
    //     ->getMock();

    //     $delegate->expects($this->once())
    //     ->method('handle');

    //     $token = $this->csrf->generateToken();

    //     $request= (new ServerRequest('POST', '/demo'))
    //     ->withParsedBody(['_csrf' => $token]);

    //     $this->csrf->process($request, $delegate);
    // }


    // public function testPOSTMethodNoPassWithTokenInvalid()
    // {
    //     $delegate = $this->getMockBuilder(RequestHandlerInterface::class)
    //     ->setMethods(['handle'])
    //     ->getMock();

    //     $delegate->expects($this->never())
    //     ->method('handle');

    //     $this->csrf->generateToken();

    //     $request= (new ServerRequest('POST', '/demo'))
    //     ->withParsedBody(['_csrf' => 'invalid']);

    //     $this->expectException(Exception::class);

    //     $this->csrf->process($request, $delegate);
    // }


    // public function testPOSTMethodPassWithTokenOnce()
    // {
    //     $delegate = $this->getMockBuilder(RequestHandlerInterface::class)
    //     ->setMethods(['handle'])
    //     ->getMock();

    //     $delegate->expects($this->once())
    //     ->method('handle');

    //     $token = $this->csrf->generateToken();

    //     $request= (new ServerRequest('POST', '/demo'))
    //     ->withParsedBody(['_csrf' => $token]);

    //     $this->csrf->process($request, $delegate);
    //     $this->expectException(Exception::class);
    //     $this->csrf->process($request, $delegate);
    // }

    // public function testLimitToken()
    // {
    //     $last = '';
    //     for ($i=0; $i < 100; $i++) { 
    //         $last = $this->csrf->generateToken();
    //     }

    //     $this->assertCount(50, $this->csrf->getSession()['csrf']);
    //     $this->assertEquals($last, $this->csrf->getSession()['csrf'][49]);
    // }


}