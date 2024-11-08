<?php
namespace ChidoUkaigwe\Framework\Http\Middleware;

use ChidoUkaigwe\Framework\Http\Exception\HttpException;
use ChidoUkaigwe\Framework\Http\Exception\HttpRequestMethodException;
use ChidoUkaigwe\Framework\Http\Request;
use ChidoUkaigwe\Framework\Http\Response;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class ExtractRouteInfo implements MiddlewareInterface
{

    public function __construct(private array $routes)
    {

    }

    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {

            foreach ($this->routes as $route) {
                $routeCollector->addRoute(...$route);
            }

        });

        //  Dispatch a URI, to obtain the route info

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPathInfo()
        );

        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:

                //  Set $request->routeHandler
                $request->setRouteHandler($routeInfo[1]);
                //  Set $request->routeHandlerArgs
                $request->setRouteHandlerArgs($routeInfo[2]);
                //  Inject route middleware on handler
                if (is_array($routeInfo[1]) && isset($routeInfo[1][2])) {
                    $requestHandler->injectMiddleware($routeInfo[1][2]);
                }
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(',', $routeInfo[1]);
                $e = new HttpRequestMethodException("The allowed methods are $allowedMethods");
                $e->setStatusCode(405);
                throw $e;
                break;
            default:
                $e = new HttpException('Not Found');
                $e->setStatusCode(404);
                throw $e;
                break;
        }

        return $requestHandler->handle($request); // Pass the request to the next middleware in the stack
    }
}