<?php

require('public/index.php');
$container  = $app->getContainer();
$dbInformation = $container->get('database');

$migrations = [];
$seeds = [];

foreach($modules as $module){
    if($module::MIGRATIONS){
        $migrations[] = $module::MIGRATIONS;
    }
    if($module::SEEDS){
        $seeds[] = $module::SEEDS;
    }
}

return
[
    'paths' => [
        'migrations' => $migrations,
        'seeds' => $seeds
    ],
    'environments' => [
        // 'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => $dbInformation['database.host'],
            'name' => $dbInformation['database.name'],
            'user' => $dbInformation['database.username'],
            'pass' => $dbInformation['database.password'],
            'port' => '3306',
            'charset' => 'utf8',
        ],
        // 'production' => [
        //     'adapter' => 'mysql',
        //     'host' => 'localhost',
        //     'name' => 'development_db',
        //     'user' => 'root',
        //     'pass' => '',
        //     'port' => '3306',
        //     'charset' => 'utf8',
        // ],
        'testing' => [
            'adapter' => 'sqlite',
            'memory' => true,
            'name' => 'testing_db',
        ]
    ],
    'version_order' => 'creation'
];
