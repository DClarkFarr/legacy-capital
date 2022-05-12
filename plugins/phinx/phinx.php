<?php
$dir = __DIR__;

$configPath = realpath($dir . '/../../../../../wp-config.php');

define("PHINX", 1);

require_once $configPath;

$phinx =
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/../../migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/../../seeds'
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => 'development',
            'production' => [
                'adapter' => 'mysql',
                'host' => 'localhost',
                'name' => 'production_db',
                'user' => 'root',
                'pass' => '',
                'port' => '3306',
                'charset' => 'utf8',
            ],
            'development' => [
                'adapter' => 'mysql',
                'host' => DB_HOST,
                'name' => DB_NAME,
                'user' => DB_USER,
                'pass' => DB_PASSWORD,
                'port' => '3306',
                'charset' => 'utf8',
            ],
        ],
        'version_order' => 'creation'
    ];

return $phinx;
