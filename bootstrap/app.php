<?php

declare(strict_types=1);

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;

// Create the container
$container = Container::getInstance();

// Load config
$config = new Repository;
$filesystem = new Filesystem;

$configPath = dirname(__DIR__) . '/config';

if (is_dir($configPath)) {
    $configFiles = $filesystem->files($configPath);

    foreach ($configFiles as $file) {
        $key = basename($file->getFilename(), '.php');
        $config->set($key, require $file->getPathname());
    }
}

// Bind config to the container
$container->instance('config', $config);

// Set the container for facades
Facade::setFacadeApplication($container);

return $container;
