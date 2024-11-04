<?php
namespace ChidoUkaigwe\Framework\Http\Middleware;

use ChidoUkaigwe\Framework\Http\Request;
use ChidoUkaigwe\Framework\Http\Response;

class Authenticate implements MiddlewareInterface
{
    private bool $authenticated = true;

    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
      
        if (!$this->authenticated) {
            return new Response('Authentication Failed', 401);
        }

        return $requestHandler->handle($request);

    }
}