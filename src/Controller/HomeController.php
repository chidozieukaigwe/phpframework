<?php

namespace App\Controller;

use App\Widget;
use ChidoUkaigwe\Framework\Controller\AbstractController;
use ChidoUkaigwe\Framework\Http\Response;


class HomeController extends AbstractController
{
    public function __construct(
        private Widget $widget,
    )
    {
        
    }

    public function index(): Response
    {
       return $this->render('home.html.twig');
    }
}