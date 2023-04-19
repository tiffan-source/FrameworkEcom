<?php

namespace Tests\Framework\Middleware;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Framework\Middleware\NotFoundMiddleware;
use Psr\Http\Message\ServerRequestInterface;

class NotFoundMiddlewareTest extends TestCase {
    public function test404Return(){
        $this->assertEquals(404, call_user_func_array(
            new NotFoundMiddleware(), [
                new ServerRequest('GET', '/'),
                function(){}
                ]
        )->getStatusCode());
    }
}