<?php

namespace Framework\Renderer\Twig\TwigExtension;

use Framework\Router;
use Twig\TwigFunction;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\DefaultView;
use Twig\Extension\AbstractExtension;

class PagerTwigExtension extends AbstractExtension {

    private $router;

    public function __construct(Router $router){
        $this->router = $router;
    }

    public function getFunctions(){
        return [
            new TwigFunction('paginate', [$this, 'paginate'], ['is_safe' => ['html']])
        ];
    }

    public function paginate(Pagerfanta $paginatedResult, string $routeName, array $routeArgs = [], array $queryArgs = []) : string{
        $view = new DefaultView();
        return $view->render($paginatedResult, function(int $page) use ($routeName, $queryArgs, $routeArgs){
            if($page > 1)
                $queryArgs['p'] = $page;

            return $this->router->generateUri($routeName, $routeArgs, $queryArgs);
        });
    }
}