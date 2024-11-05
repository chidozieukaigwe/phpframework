<?php
namespace ChidoUkaigwe\Framework\Http\Event;

use ChidoUkaigwe\Framework\EventDispatcher\Event;
use ChidoUkaigwe\Framework\Http\Request;
use ChidoUkaigwe\Framework\Http\Response;

class ResponseEvent extends Event
{
    public function __construct(
        private Response $response,
        private Request $request,
    ){

    }
        public function getResponse()
        {
                return $this->response;
        }

        public function getRequest()
        {
                return $this->request;
        }
}