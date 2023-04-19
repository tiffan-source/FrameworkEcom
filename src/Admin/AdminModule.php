<?php

namespace App\Admin;

use Framework\Module;
use Framework\Router;
use App\Admin\Actions\AdminAction;
use Psr\Container\ContainerInterface;
use App\Admin\Actions\DashboardAction;
use Framework\Renderer\RendererInterface;

class AdminModule extends Module
{
    const DEFINITIONS = __DIR__ . '/config.php';

    public function __construct(ContainerInterface $container)
    {
        $router = $container->get(Router::class);
        $container->get(RendererInterface::class)->addPath(__DIR__ . '/views', 'admin');
        $router->get(
            $container->get('admin.prefix'),
            [$container->get(DashboardAction::class), 'dashboard'],
            'admin');
    }
}