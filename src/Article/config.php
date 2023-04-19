<?php

use App\Article\ArticleModule;
use App\Article\ArticleWidget;

return [
    // 'blog.prefix' => '/blog',
    // ArticleModule::class => \DI\object()->constructorParameter('prefix', \DI\get('blog.prefix'))

    'admin.widgets' => \DI\add([
        \DI\get(ArticleWidget::class)
    ])
];