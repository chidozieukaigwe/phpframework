<?php
namespace ChidoUkaigwe\Framework\Http\Middleware;

use ChidoUkaigwe\Framework\Http\Request;
use ChidoUkaigwe\Framework\Http\Response;
use ChidoUkaigwe\Framework\Routing\RouterInterface;
use Psr\Container\ContainerInterface;

class RouterDispatch implements MiddlewareInterface
{

    public function __construct(private RouterInterface $router, private ContainerInterface $container)
    {

    }

    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {

        [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);

        $response = call_user_func_array($routeHandler, $vars);

        return $response;
    }
}