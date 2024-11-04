<?php
namespace App\Controller;

use App\Form\User\RegistrationForm;
use App\Repository\UserMapper;
use ChidoUkaigwe\Framework\Controller\AbstractController;
use ChidoUkaigwe\Framework\Http\RedirectResponse;
use ChidoUkaigwe\Framework\Http\Response;

class RegistrationController extends AbstractController
{
    public function __construct(private UserMapper $userMapper)
    {
        
    }

    public function index(): Response
    {
        return $this->render('register.html.twig');
    }

    public function register(): Response
    {
        //  create a form model which will 
        $form = new RegistrationForm($this->userMapper);

        $form->setFields(
            $this->request->input('username'),
            $this->request->input('password')
        );
        // Validate
        // if validation errors - add to session, redirect to form 
        if ($form->hasValidationErrors()){
            
            foreach($form->getValidationErrors() as $error ) {
                $this->request->getSession()->setFlash('error', $error);
            }

            return new RedirectResponse('/register');
        }

          // register the user by calling $form->save()
          $user = $form->save();


        //  Add a session success message
        $this->request->getSession()->setFlash('success', sprintf('User %s created', $user->getUsername()));
        // log user in

        // Redirect to somewhere useful
        return new RedirectResponse('/');

    }
}