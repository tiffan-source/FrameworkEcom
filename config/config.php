<?php

use Framework\Router;
use Framework\Router\RouterFactory;
use Psr\Container\ContainerInterface;
use Framework\Session\SessionInterface;
use Framework\Middleware\CSRFMiddleware;
use Framework\Session\PHPSessionFactory;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\Twig\TwigRendererFactory;
use Framework\Renderer\Twig\TwigExtension\CSRFTwigExtension;
use Framework\Renderer\Twig\TwigExtension\FormTwigExtension;
use Framework\Renderer\Twig\TwigExtension\TextTwigExtension;
use Framework\Renderer\Twig\TwigExtension\TimeTwigExtension;
use Framework\Renderer\Twig\TwigExtension\FlashTwigExtension;
use Framework\Renderer\Twig\TwigExtension\PagerTwigExtension;
use Framework\Renderer\Twig\TwigExtension\RouterTwigExtension;
use Framework\Renderer\Twig\TwigExtension\AdminMenuTwigExtension;


return [
    'database' => [
        'database.host' => 'localhost',
        'database.username' => 'tiffane',
        'database.password' => 'root',
        'database.name' => 'ecom'
    ],

    'view.path' => dirname(__DIR__) . '/views',

    'twig.extensions' => [
        RouterTwigExtension::class,
        PagerTwigExtension::class,
        TextTwigExtension::class,
        TimeTwigExtension::class,
        FlashTwigExtension::class,
        FormTwigExtension::class,
        CSRFTwigExtension::class
    ],
    
    RendererInterface::class => \DI\factory(TwigRendererFactory::class),
    
    Router::class => \DI\factory(RouterFactory::class),

    \PDO::class => function(ContainerInterface $c){
        $db = $c->get('database');
        return $pdo = new \PDO(
            'mysql:host='.$db['database.host'].';dbname='.$db['database.name'],
            $db['database.username'],
            $db['database.password'],
            [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]
        );
    },

    SessionInterface::class => \DI\factory(PHPSessionFactory::class),

    CSRFMiddleware::class => function(ContainerInterface $c){
        return new CSRFMiddleware($c->get(SessionInterface::class));
    }
];