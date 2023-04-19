<?php

namespace Tests\Framework;

use Framework\Router;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;
use Framework\Renderer\RendererInterface;

class RouterTest extends TestCase {

    public function setUp():void{
        $this->router = new Router();
    }

    public function testGetMethod(){
        $request = new ServerRequest('GET', '/blog'); 
        $this->router->get('/blog', function(){return 'hello';}, 'blog');
        $route = $this->router->match($request);

        $this->assertEquals('blog', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
    }


    public function testGetMethodIfUrlNotExist(){
        $request = new ServerRequest('GET', '/blog'); 
        $this->router->get('/blag', function(){}, 'blog');
        $route = $this->router->match($request);

        $this->assertEquals(null, $route);
    }

    public function testGetMethodWithSlug(){
        $request = new ServerRequest('GET', '/blog/article-18');
        $this->router->get('/blog', function(){return 'hello';}, 'blog');
        $this->router->get('/blog/{slug}-{id}', function(){}, 'blog.show');
        $route = $this->router->match($request);

        $this->assertEquals('blog.show', $route->getName());
        $this->assertEquals(['slug' => 'article', 'id' => '18'], $route->getParameters());
    }

    public function testGenerateUri(){
        $this->router->get('/blog', function(){return 'hello';}, 'blog');
        $this->router->get('/blog/{slug}-{id}', function(){}, 'blog.show');
        $uri = $this->router->generateUri('blog.show', ['slug' => 'article', 'id' => '18']);

        $this->assertEquals('/blog/article-18', $uri);
    }


    // public function testGenerateUriPost(){
    //     $this->router->get('/blog', function(){return 'hello';}, 'blog');
    //     $this->router->post('/blog/{id}', function(){}, 'blog.show');
    //     $uri = $this->router->generateUri('blog.show', ['id' => '18']);

    //     $this->assertEquals('/blog/18', $uri);
    // }

    public function testGenerateUriWithQueryParams(){
        $this->router->get('/blog', function(){return 'hello';}, 'blog');
        $this->router->get('/blog/{slug}-{id}', function(){}, 'blog.show');
        $uri = $this->router->generateUri('blog.show',
        ['slug' => 'article', 'id' => '18'],
        ['p' => 3, 'test' => 'Bonjour']
        );

        $this->assertEquals('/blog/article-18?p=3&test=Bonjour', $uri);
    }

    public function testRouterWithSameName(){
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blog', function(){return 'get';}, 'blog');
        $this->router->post('/blog', function(){return 'post';}, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals('get', call_user_func_array($route->getCallback(), [$request]));
    }

}