<?php

namespace ChidoUkaigwe\Framework\Http;

use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;

class Kernel 
{
    public function handle(Request $request): Response
    {
       
        // Create a dispatcher
        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {

            $routes = include BASE_PATH . '/routes/web.php';

            foreach ($routes as $route) {
                $routeCollector->addRoute(...$route);
            }

            // $routeCollector->addRoute('GET', '/', function() {
            //     $content = '<h1>Hello World From Kernel</h1>';

            //     return new Response($content);
            // });

            // $routeCollector->addRoute('GET', '/posts/{id:\d+}', function($routeParams) {
            //     $content = "<h1>This is post {$routeParams['id']}</h1>";

            //     return new Response($content);
            // });
        });

        //  Dispatch a URI, to obtain the route info

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPathInfo()
        );

        [$status, [$controller, $method], $vars] = $routeInfo;

        $response = (new $controller())->$method($vars);

        return $response;

    }
}