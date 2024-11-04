<?php
namespace ChidoUkaigwe\Framework\Http\Middleware;

use ChidoUkaigwe\Framework\Http\Request;
use ChidoUkaigwe\Framework\Http\Response;

class Dummy implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response 
    {
        return $requestHandler->handle($request);
        
    }
}