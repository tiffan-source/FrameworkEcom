<?php

namespace Framework;

use Framework\Router\Route;
use Aura\Router\RouterContainer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class Router {

    private $container;

    public function __construct(){
        $this->container = new RouterContainer();
    }

    public function get(string $path, callable $callable, string $name) {
        $map = $this->container->getMap();

        $map->get($name, $path, $callable);
    }

    public function post(string $path, callable $callable, string $name) {
        $map = $this->container->getMap();

        $map->post($name.'post', $path, $callable);
    }

    public function delete(string $path, callable $callable, string $name) {
        $map = $this->container->getMap();

        $map->delete($name, $path, $callable);
    }

    public function crud(string $routePrefix, string $action, string $prefixName, ContainerInterface $container){
        $actionClass = $container->get($action);
        $this->get($routePrefix, [$actionClass, 'index'], $prefixName . '.index');
        $this->get($routePrefix . '/{id}', [$actionClass, 'edit'], $prefixName . '.edit');
        $this->post($routePrefix . '/{id}', [$actionClass, 'edit'], $prefixName . '.edit');

        $this->get($routePrefix . '/new/create', [$actionClass, 'create'], $prefixName . '.create');
        $this->post($routePrefix . '/new/create', [$actionClass, 'create'], $prefixName . '.create');
        
        $this->delete($routePrefix . '/{id}', [$actionClass, 'delete'], $prefixName . '.delete');
    }

    public function match(ServerRequestInterface $request): ?Route{
        $matcher = $this->container->getMatcher();

        $route = $matcher->match($request);

        if($route)
            return new Route(
                $route->name,
                $route->handler,
                $route->attributes
            );
        return null;
    }

    public function generateUri(string $name, array $attribute = [], array $queryParam = []): ?string{
        $uri = $this->container->getGenerator()->generate($name, $attribute);
        if(!empty($queryParam))
            $uri .= '?' . http_build_query($queryParam);
        return $uri;
    }
}