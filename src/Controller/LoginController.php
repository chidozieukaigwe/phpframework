<?php
namespace App\Controller;

use ChidoUkaigwe\Framework\Authentication\SessionAuthentication;
use ChidoUkaigwe\Framework\Controller\AbstractController;
use ChidoUkaigwe\Framework\Http\RedirectResponse;
use ChidoUkaigwe\Framework\Http\Response;

class LoginController extends AbstractController
{

    public function __construct(private SessionAuthentication $authComponent)
    {

    }

    public function index(): Response
    {
        return $this->render('login.html.twig');
    }

    public  function login(): Response
    {
        //  Attempt to autheticate the user using a security component (bool)
        // Create a session for the user
        $userIsAuthenticated = $this->authComponent->authenticate(
            $this->request->input('username'),
            $this->request->input('password')
        );

        // if successful, retrieve the user
        if (!$userIsAuthenticated) {
            $this->request->getSession()->setFlash('error', 'Invalid username or password');
            return new RedirectResponse('/login');
        }
        $user = $this->authComponent->getUser();

        $this->request->getSession()->setFlash('success', 'You are now logged in');

         // redirect the user to intended location

         return new RedirectResponse('/dashboard');
    }

    public function logout(): Response
    {
        // logout the user
        $this->authComponent->logout();

        //  set a logout session message
        $this->request->getSession()->setFlash('success', 'You have been logged out');

        //  Redirect to login page
        return new RedirectResponse('/login');

    }

}