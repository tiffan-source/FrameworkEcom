<?php

namespace Framework\Renderer\Twig;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Psr\Container\ContainerInterface;
use Framework\Renderer\Twig\TwigRenderer;
use Twig\Extension\DebugExtension;

class TwigRendererFactory{
    public function __invoke(ContainerInterface $container) : TwigRenderer{
        $loader = new FilesystemLoader($container->get('view.path'));
        $twig = new Environment($loader, ['debug' => true]);
        $twig->addExtension(new DebugExtension());
        foreach($container->get('twig.extensions') as $extension)
            $twig->addExtension($container->get($extension));
    
        return new TwigRenderer($twig);
    }
}