<?php
namespace ChidoUkaigwe\Framework\Http\Middleware;

use ChidoUkaigwe\Framework\Http\Exception\TokenMismatchException;
use ChidoUkaigwe\Framework\Http\Request;
use ChidoUkaigwe\Framework\Http\Response;

class VerifyCsrfToken implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        //  Proceed if not state change request
        if (!in_array($request->getMethod(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return $requestHandler->handle($request);
        }

        //  Retrieve the tokens
        $tokenFromSession = $request->getSession()->get('csrf_token');
        $tokenFromRequest = $request->input('_token');
         ;    
    
        if (!hash_equals($tokenFromSession, $tokenFromRequest)) {
              //  Throw an exception on mismatch
             $exception = new TokenMismatchException('Your request could not be validated. Please try again');
             $exception->setStatusCode(Response::HTTP_FORBIDDEN);
             throw $exception;

        }

        //  Proceed
        return $requestHandler->handle($request);
    }
}