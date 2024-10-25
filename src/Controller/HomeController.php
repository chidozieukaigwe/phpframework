<?php

namespace App\Controller;

use ChidoUkaigwe\Framework\Http\Response;

class HomeController
{
    public function index(): Response
    {
        $content = "<h1>Hello World";

        return new Response($content);
    }
}