<?php

namespace ChidoUkaigwe\Framework\Http;

use ChidoUkaigwe\Framework\EventDispatcher\EventDispatcher;
use ChidoUkaigwe\Framework\Http\Event\ResponseEvent;
use ChidoUkaigwe\Framework\Http\Request;
use ChidoUkaigwe\Framework\Http\Response;
use ChidoUkaigwe\Framework\Routing\Router;
use ChidoUkaigwe\Framework\Routing\RouterInterface;
use ChidoUkaigwe\Framework\Http\Exception\HttpException;
use ChidoUkaigwe\Framework\Http\Exception\HttpRequestMethodException;
use ChidoUkaigwe\Framework\Http\Middleware\RequestHandlerInterface;
use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

class Kernel 
{
    private string $appEnv;

    public function __construct(
        private ContainerInterface $container,
        private RequestHandlerInterface $requestHandler,
        private EventDispatcher $eventDispatcher,
    )
    {
        $this->appEnv = $this->container->get("APP_ENV");
    }

    public function handle(Request $request): Response
    {

        try {
            $response = $this->requestHandler->handle($request);

        }catch (\Exception $exception) {
            $response = $this->createExceptionResponse($exception);
        }

        $response->setStatus(502);

        $this->eventDispatcher->dispatch(new ResponseEvent($response, $request));

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

    public function terminate(Request $request, Response $response): void
    {
        $request->getSession()?->clearFlash();
        $request->getSession()?->remove('auth_id');
    }
}