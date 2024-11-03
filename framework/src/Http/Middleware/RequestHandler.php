<?php
namespace ChidoUkaigwe\Framework\Http\Middleware;

use ChidoUkaigwe\Framework\Http\Request;
use ChidoUkaigwe\Framework\Http\Response;
use Psr\Container\ContainerInterface;

class RequestHandler implements RequestHandlerInterface
{
    private array $middleware = [
          // Add more middleware classes here as needed
        Authenticate::class,
        RouterDispatch::class, // This should be last in the middleware stack
      
    ];

    public function __construct(
        private ContainerInterface $container,
        
    )
    {

    }

    public function handle(Request $request): Response
    {
        //  if there no middleware classes to execute, return a default reponse
        // A response should have been returned before the list becomes empty
        if (empty($this->middleware)){
            return new Response('Its totally borked, mate. Contact support', 500);
        }
        // Get the next middlware class to execute
        $middlewareClass = array_shift($this->middleware);

        $middleware = $this->container->get($middlewareClass);
        // Create a new instance of the middlware call process on it
        $response = $middleware->process($request, $this);

        return $response;
    }
}