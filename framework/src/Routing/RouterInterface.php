<?php

namespace ChidoUkaigwe\Framework\Routing;

use ChidoUkaigwe\Framework\Http\Request;
use Psr\Container\ContainerInterface;

interface RouterInterface
{
    public function dispatch(Request $request, ContainerInterface $container);

}