<?php

namespace ChidoUkaigwe\Framework\Http;

use ChidoUkaigwe\Framework\Session\SessionInterface;

class Request 
{

    private SessionInterface $session;
    private mixed $routeHandler;
    private array $routeHandlerArgs;


    public function __construct(
        public readonly array $getParams,
        public readonly array $postParams,
        public readonly array $cookies,
        public readonly array $files,
        public readonly array $server
    ) 
    {
        
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getPathInfo(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function getMethod(): string
    {
        return  $this->server['REQUEST_METHOD'];
    }

    public function getSession()
    {
        return $this->session;
    }

  

    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    public function input($key): mixed 
    {
        return $this->postParams[$key];
    }

    /**
     * Get the value of routeHandlerArgs
     */ 
    public function getRouteHandlerArgs()
    {
        return $this->routeHandlerArgs;
    }

    /**
     * Set the value of routeHandlerArgs
     *
     * @return  self
     */ 
    public function setRouteHandlerArgs($routeHandlerArgs)
    {
        $this->routeHandlerArgs = $routeHandlerArgs;

        return $this;
    }

    /**
     * Get the value of routeHandler
     */ 
    public function getRouteHandler()
    {
        return $this->routeHandler;
    }

    /**
     * Set the value of routeHandler
     *
     * @return  self
     */ 
    public function setRouteHandler($routeHandler)
    {
        $this->routeHandler = $routeHandler;

        return $this;
    }
}