<?php

namespace Framework\Renderer\Twig\TwigExtension;

use Framework\Router;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class RouterTwigExtension extends AbstractExtension{

    private $router;

    public function __construct(Router $router){
        $this->router = $router;
    }

    public function getFunctions(){
        return [
            new TwigFunction('path', [$this, 'pathFor']),
            new TwigFunction('is_subpath', [$this, 'is_subpath'])
        ];
    }

    public function pathFor(string $path, array $params = []):string{
        return $this->router->generateUri($path, $params);
    }

    public function is_subpath(string $routeName) : bool
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $expect = $this->router->generateUri($routeName);

        return strpos($uri, $expect) !== false;
    }
}