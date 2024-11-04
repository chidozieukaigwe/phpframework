<?php

use App\Repository\UserRepository;
use ChidoUkaigwe\Framework\Authentication\SessionAuthentication;
use ChidoUkaigwe\Framework\Console\Application;
use ChidoUkaigwe\Framework\Console\Command\MigrateDatabase;
use ChidoUkaigwe\Framework\Console\Kernel as ConsoleKernel;
use ChidoUkaigwe\Framework\Controller\AbstractController;
use ChidoUkaigwe\Framework\Dbal\ConnectionFactory;
use ChidoUkaigwe\Framework\Http\Kernel;
use ChidoUkaigwe\Framework\Http\Middleware\RequestHandler;
use ChidoUkaigwe\Framework\Http\Middleware\RequestHandlerInterface;
use ChidoUkaigwe\Framework\Http\Middleware\RouterDispatch;
use ChidoUkaigwe\Framework\Routing\Router;
use ChidoUkaigwe\Framework\Routing\RouterInterface;
use ChidoUkaigwe\Framework\Session\SessionInterface;
use ChidoUkaigwe\Framework\Template\TwigFactory;
use Doctrine\DBAL\Connection;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(BASE_PATH . '/.env');

$container = new Container();

$container->delegate(new ReflectionContainer(true));

//  parameters for application config 

$routes = include BASE_PATH . '/routes/web.php';
$appEnv = $_SERVER['APP_ENV'];
$templatesPath = BASE_PATH . '/templates';

$container->add("APP_ENV", new StringArgument($appEnv));
$databaseUrl = 'sqlite:///'. BASE_PATH . '/var/db.sqlite';

$container->add('base-commands-namespace', new StringArgument('ChidoUkaigwe\\Framework\\Console\\Command\\'));

//  services

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)
         ->addMethodCall('setRoutes', [new ArrayArgument($routes)]);

$container->add(RequestHandlerInterface::class, RequestHandler::class)
    ->addArgument($container);


$container->add(Kernel::class)
          ->addArguments([
            $container,
            RouterInterface::class,
            RequestHandlerInterface::class
          ]);
     

$container->add(ConsoleKernel::class)
          ->addArguments([$container, Application::class]);

$container->add(Application::class)
          ->addArgument($container);

$container->addShared(SessionInterface::class, \ChidoUkaigwe\Framework\Session\Session::class);

$container->add('template-renderer-factory', TwigFactory::class)
    ->addArguments([
        SessionInterface::class,
        new StringArgument($templatesPath),
    ]);

$container->addShared('twig', function () use ($container) {
    return $container->get('template-renderer-factory')->create();
});

$container->add(AbstractController::class);

$container->inflector(AbstractController::class)
         ->invokeMethod('setContainer', [$container]);

$container->add(ConnectionFactory::class)
    ->addArguments([
        new StringArgument($databaseUrl),
    ]);

$container->addShared(Connection::class, function () use ($container):Connection 
{
    return $container->get(ConnectionFactory::class)->create();
});

$container->add('database:migrations:migrate', MigrateDatabase::class)
            ->addArguments([
                Connection::class,
                new StringArgument(BASE_PATH. '/migrations'),
            ]);

$container->add(RouterDispatch::class)
         ->addArguments([
             RouterInterface::class,
             $container,
         ]);

$container->add(SessionAuthentication::class)
         ->addArguments([
            UserRepository::class,
            SessionInterface::class,
 
        ]);

return $container;