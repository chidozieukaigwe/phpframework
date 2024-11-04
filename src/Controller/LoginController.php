<?php
namespace App\Controller;

use ChidoUkaigwe\Framework\Controller\AbstractController;
use ChidoUkaigwe\Framework\Http\Response;

class LoginController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('login.html.twig');
    }

    public  function login(): Response
    {
        //  Attempt to autheticate the user using a security component (bool)
        // Create a session for the user

        // if successful, retrieve the user

        // redirect the user to intended location
    }
}