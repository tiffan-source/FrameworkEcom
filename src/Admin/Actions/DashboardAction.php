<?php

namespace App\Admin\Actions;

use App\Admin\AdminWidgetInterface;
use Framework\Renderer\RendererInterface;

class DashboardAction {

    private $renderer;
    private $widgets;

    public function __construct(RendererInterface $renderer, array $widgets)
    {
        $this->renderer= $renderer;
        $this->widgets = $widgets;
    }

    public function dashboard()
    {
        $widget = array_reduce(
            $this->widgets,
            function(string $acc, AdminWidgetInterface $key){
                return $acc . $key->render();
            },
            ''
        );

        return $this->renderer->render('@admin/dashboard', compact('widget'));
    }
}