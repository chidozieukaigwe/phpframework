<?php
namespace ChidoUkaigwe\Framework\Controller;

use ChidoUkaigwe\Framework\Http\Request;
use ChidoUkaigwe\Framework\Http\Response;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    protected Request $request;

    protected ?ContainerInterface $container = null;

   public function setContainer(ContainerInterface $container): void
   {
    $this->container = $container;
   }

   public function render(string $template, array $parameters = [], Response $response = null):Response
   {
    $content = $this->container->get('twig')->render($template, $parameters);

    $response ??= new Response();

    $response->setContent($content);

    return $response;
   }

    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }
}