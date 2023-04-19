<?php

namespace Framework\Renderer\Twig;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Framework\Renderer\RendererInterface;


class TwigRenderer implements RendererInterface{

    const DEFAULT_NAMESPACE = '__MAIN__';

    private $paths = [];
    private $globals = [];

    private $twig;

    public function __construct(Environment $twig){
        $this->twig = $twig;
    }

    public function addPath(string $path, ?string $namespace = null): void{
        $this->twig->getLoader()->addPath($path, $namespace);
    }

    public function render(string $views, array $params = []):string{
     return $this->twig->render($views . '.twig', $params);
    }

    private function hasNamespace(string $views) : bool{
    }

    private function getNamespace(string $views) : string{
    }

    private function replaceNamespace(string $views) : string{
    }

    public function addGlobal(string $key, $value) : void{
        $this->twig->addGlobal($key, $value);
    }

    public function getTwig() : Environment
    {
        return $this->twig;
    }
}