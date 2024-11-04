<?php
namespace ChidoUkaigwe\Framework\Authentication;

use ChidoUkaigwe\Framework\Session\SessionInterface;

class SessionAuthentication implements SessionAuthInterface
{

    private AuthUserInterface $user;

    public function __construct(
        private AuthRepositoryInterface $authRepository,
        private SessionInterface $session
        )
    {

    }
    public function authenticate(string $username, string $password): bool
    {

        // query db for user using username 
        $user = $this->authRepository->findByUsername($username);

        if(!$user){
            return false;
        }

        //  Does the hashed user pw match the has of the attempted password
        if (password_verify($password, $user->getPassword())) {
           
            // if yes log the user in 
            $this->login($user);
          
            return true;
        }

        return false;
            // if yes log the user in 

            //  return true

        // return false
        
        return false;

    }

    public function getUser(): AuthUserInterface
    {
        return $this->user;

    }

    public function logout(): void
    {

    }

    public function login(AuthUserInterface $user): void
    {
        //  start a session 
        $this->session->start();
        //  log user in 
        $this->session->set('auth_id', $user->getAuthId());
        //  set the user
        $this->user = $user;
    }
}