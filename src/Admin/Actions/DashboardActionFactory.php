<?php

namespace App\Admin\Actions;

use Psr\Container\ContainerInterface;
use App\Admin\Actions\DashboardAction;
use Framework\Renderer\RendererInterface;

class DashboardActionFactory {

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container= $container;
    }

    public function __invoke(){
        // var_dump($this->container->get('admin.widgets'));die();
        return new DashboardAction(
            $this->container->get(RendererInterface::class),
            $this->container->get('admin.widgets')
        );
    }
}