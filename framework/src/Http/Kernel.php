<?php

namespace ChidoUkaigwe\Framework\Http;

use ChidoUkaigwe\Framework\Http\Request;
use ChidoUkaigwe\Framework\Http\Response;
use ChidoUkaigwe\Framework\Routing\Router;
use ChidoUkaigwe\Framework\Routing\RouterInterface;
use ChidoUkaigwe\Framework\Http\Exception\HttpException;
use ChidoUkaigwe\Framework\Http\Exception\HttpRequestMethodException;
use Psr\Container\ContainerInterface;

class Kernel 
{
    private string $appEnv;

    public function __construct(
        private ContainerInterface $container,
        private RouterInterface $router
    )
    {
        $this->appEnv = $this->container->get("APP_ENV");
    }

    public function handle(Request $request): Response
    {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);
            $response = call_user_func_array($routeHandler, $vars);
        }catch (\Exception $exception) {
            $response = $this->createExceptionResponse($exception);
        }

        return $response;
       
    }

    /**
     * @throws \Exception $exception
     */
    private function createExceptionResponse(\Exception $exception): Response
    {
        if (in_array($this->appEnv, ['dev', 'test'])) {
            throw $exception;
        }
        
        if ($exception instanceof HttpException) {
            return new Response($exception->getMessage(), $exception->getStatusCode());
        }

        return new Response('Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}