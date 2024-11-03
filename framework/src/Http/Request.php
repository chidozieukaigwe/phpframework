<?php

namespace ChidoUkaigwe\Framework\Http;

use ChidoUkaigwe\Framework\Session\SessionInterface;

class Request 
{

    private SessionInterface $session;

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
}