<?php

namespace ChidoUkaigwe\Framework\Routing;

use ChidoUkaigwe\Framework\Controller\AbstractController;
use ChidoUkaigwe\Framework\Http\Request;

use Psr\Container\ContainerInterface;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{

    public function dispatch(Request $request, ContainerInterface $container): array
    {
        $routeHandler = $request->getRouteHandler();
        $routeHandlerArgs = $request->getRouteHandlerArgs();

        if (is_array($routeHandler)) {
            [$controllerId, $method] = $routeHandler;
            $controller = $container->get($controllerId);
            if (is_subclass_of($controller, AbstractController::class)) {
                $controller->setRequest($request);
            }
            $routeHandler = [$controller, $method];
        }

        // $vars['request'] = $request;

        return [$routeHandler, $routeHandlerArgs];
        
    }

}