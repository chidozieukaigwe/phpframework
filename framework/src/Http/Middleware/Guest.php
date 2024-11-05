<?php
namespace ChidoUkaigwe\Framework\Http\Middleware;

use ChidoUkaigwe\Framework\Authentication\SessionAuthentication;
use ChidoUkaigwe\Framework\Http\RedirectResponse;
use ChidoUkaigwe\Framework\Http\Request;
use ChidoUkaigwe\Framework\Http\Response;
use ChidoUkaigwe\Framework\Session\Session;
use ChidoUkaigwe\Framework\Session\SessionInterface;

class Guest implements MiddlewareInterface
{
    private bool $authenticated = true;

    public function __construct(private SessionInterface $session)
    {}

    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {

        $this->session->start();
      
        if ($this->session->has(Session::AUTH_KEY)) {
            return new RedirectResponse('/dashboard');
        }

        return $requestHandler->handle($request);

    }
}