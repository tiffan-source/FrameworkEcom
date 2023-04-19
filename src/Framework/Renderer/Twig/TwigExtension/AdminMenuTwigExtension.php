<?php

namespace Framework\Renderer\Twig\TwigExtension;

use Twig\TwigFunction;
use App\Admin\AdminWidgetInterface;
use Psr\Container\ContainerInterface;
use Twig\Extension\AbstractExtension;

class  AdminMenuTwigExtension extends AbstractExtension
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function getFunctions() : array
    {
        return [
            new TwigFunction('admin_menu', [$this, 'renderMenu'], ['is_safe' => ['html']])
        ];
    }

    public function renderMenu() : string
    {
        $widgets = $this->container->get('admin.widgets');
        $menu = array_reduce(
            $widgets,
            function(string $acc, AdminWidgetInterface $key){
                return $acc . $key->renderMenu();
            },
            ''
        );

        return $menu;
    }
}