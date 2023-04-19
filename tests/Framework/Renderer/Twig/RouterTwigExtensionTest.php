<?php

namespace Tests\Framework\Renderer\Twig;

use Framework\Router;
use PHPUnit\Framework\TestCase;
use Framework\Renderer\Twig\TwigExtension\RouterTwigExtension;

class RouterTwigExtensionTest extends TestCase
{
    private $routerExtension;

    public function setUp():void
    {
        $router = new Router();
        $router->get('/test/{id}', function(){}, 'testslug');
        $router->post('/test/{id}', function(){}, 'test');

        $this->routerExtension = new RouterTwigExtension($router);
    }

    public function testPostUriWithParams(){
        $path = $this->routerExtension->pathFor('testslug', ['id' => 8]);
        $this->assertEquals('/test/8', $path);
    }

}