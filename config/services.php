<?php

use ChidoUkaigwe\Framework\Http\Kernel;
use ChidoUkaigwe\Framework\Routing\Router;
use ChidoUkaigwe\Framework\Routing\RouterInterface;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

$container = new Container();

$container->delegate(new ReflectionContainer(true));

//  parameters for application config 

$routes = include BASE_PATH . '/routes/web.php';
$appEnv = $_SERVER['APP_ENV'];

$container->add("APP_ENV", new StringArgument($appEnv));

//  services

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)
         ->addMethodCall('setRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)
          ->addArgument($container)
          ->addArgument(RouterInterface::class);
       

return $container;