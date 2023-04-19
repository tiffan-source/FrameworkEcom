<?php

namespace Framework;

use Exception;
use Framework\Router;
use DI\ContainerBuilder;
use GuzzleHttp\Psr7\Response;
use App\Article\ArticleModule;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class App implements RequestHandlerInterface
{

    private $modules = [];
    private $router;
    private $container;
    private $config;
    private $middlewares = [];
    private $indexMiddleware = 0;

    public function getContainer() : ContainerInterface{
        if (is_null($this->container)) {
            $builder = new ContainerBuilder();
            $builder->addDefinitions($this->config);
    
            foreach ($this->modules as $module){
                if($module::DEFINITIONS){
                    $builder->addDefinitions($module::DEFINITIONS);
                }
            }
    
            $this->container = $builder->build();
        }
        
        return $this->container;
    } 

    public function addModule(string $module) : self
    {
        $this->modules[] = $module;
        return $this;
    }

    public function __construct(string $config){
        $this->config = $config;
    }

    public function pipe(string $middleware) : self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $middleware = $this->getMiddleware();

        if (is_null($middleware)) {
            throw new Exception("Plus de middleware");
        }

        if($middleware instanceof MiddlewareInterface)
        {
            return $middleware->process($request, $this);
        }

        return call_user_func_array($middleware, [$request, [$this, 'handle']]);
    }

    private function getMiddleware() : object
    {
        if(array_key_exists($this->indexMiddleware, $this->middlewares))
        {

            $middleware = $this->middlewares[$this->indexMiddleware];
            $middleware = $this->container->get($middleware);
            $this->indexMiddleware++;

            return $middleware;
        }

        return null;
    }

    public function run(ServerRequestInterface $request): ResponseInterface{
        
        foreach ($this->modules as $module){
            $this->getContainer()->get($module);
        }

        return $this->handle($request);
    }
}