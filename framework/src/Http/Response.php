<?php

namespace ChidoUkaigwe\Framework\Http;

class Response 
{
    public function __construct(
        private ?string $content = '',
        private int $status = 200,
        private array $headers = []
    )
    {
        // must be set before sending content
        //  so best to create an instantiation like here
        http_response_code($this->status);
    }

    public function send(): void
    {
        echo $this->content;
    }
}