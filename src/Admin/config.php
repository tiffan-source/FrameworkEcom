<?php

use App\Admin\Actions\DashboardAction;
use App\Admin\Actions\DashboardActionFactory;
use Framework\Renderer\Twig\TwigExtension\AdminMenuTwigExtension;

return [
    'admin.prefix' => '/admin',
    'admin.widgets' => [

    ],
    'twig.extensions' => \DI\add([
        AdminMenuTwigExtension::class
    ]),
    DashboardAction::class => \DI\factory(DashboardActionFactory::class)
];