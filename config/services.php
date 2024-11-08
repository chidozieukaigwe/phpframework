<?php

use App\Repository\UserRepository;
use ChidoUkaigwe\Framework\Authentication\SessionAuthentication;
use ChidoUkaigwe\Framework\Console\Application;
use ChidoUkaigwe\Framework\Console\Command\MigrateDatabase;
use ChidoUkaigwe\Framework\Console\Kernel as ConsoleKernel;
use ChidoUkaigwe\Framework\Controller\AbstractController;
use ChidoUkaigwe\Framework\Dbal\ConnectionFactory;
use ChidoUkaigwe\Framework\EventDispatcher\EventDispatcher;
use ChidoUkaigwe\Framework\Http\Kernel;
use ChidoUkaigwe\Framework\Http\Middleware\ExtractRouteInfo;
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
$dotenv->load(dirname(__DIR__) . '/.env');

$container = new Container();

$container->delegate(new ReflectionContainer(true));

//  parameters for application config 
$basePath = dirname(__DIR__);
$container->add('base-path', new StringArgument($basePath));
$routes = include $basePath . '/routes/web.php';
$appEnv = $_SERVER['APP_ENV'];
$templatesPath = $basePath . '/templates';

$container->add("APP_ENV", new StringArgument($appEnv));
$databaseUrl = 'sqlite:///'. $basePath . '/var/db.sqlite';

$container->add('base-commands-namespace', new StringArgument('ChidoUkaigwe\\Framework\\Console\\Command\\'));

//  services

$container->add(RouterInterface::class, Router::class);

$container->add(RequestHandlerInterface::class, RequestHandler::class)
    ->addArgument($container);

$container->addShared(EventDispatcher::class); 

$container->add(Kernel::class)
          ->addArguments([
            $container,
            RequestHandlerInterface::class,
            EventDispatcher::class,
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
                new StringArgument($basePath. '/migrations'),
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

$container->add(ExtractRouteInfo::class)
        ->addArgument(new ArrayArgument($routes));

return $container;