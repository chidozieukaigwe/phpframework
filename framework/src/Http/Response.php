<?php

namespace ChidoUkaigwe\Framework\Http;

class Response
{

    public const HTTP_INTERNAL_SERVER_ERROR = 500;
    public const HTTP_FORBIDDEN = 403;

    public function __construct(
        private ?string $content = '',
        private int $status = 200,
        private array $headers = []
    ) {
        // must be set before sending content
        //  so best to create an instantiation like here
        http_response_code($this->status);
    }

    public function send(): void
    {
        //  start output buffering
        ob_start();
        //  send headers
        foreach($this->headers as $key => $value) {
            header("$key: $value"); // Content-Length 2342
        }
        //  This will actually add the content to the buffer
        echo $this->content;

        //  Flush the buffer, sending the content to the client
        ob_end_flush();
    }

    public function setContent($content)
    {
        $this->content = $content;

        // return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getHeader(string $header): mixed
    {
        return $this->headers[$header];
    }

    public function getheaders(): array
    {
        return $this->headers;
    }

    public function setHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
