<?php
namespace ChidoUkaigwe\Framework\Authentication;

class SessionAuthentication implements SessionAuthInterface
{
    public function authenticate(string $username, string $password): bool
    {
        // query db for user using username 
        $user = $this->authUserRepository->findByUsername(['username' => $username]);
        //  Does the hashed user pw match the has of the attempted password

            // if yes log the user in 

            //  return true

        // return false
        
        return false;

    }

    public function getUser(): AuthUserInterface
    {

    }

    public function logout(): void
    {

    }

    public function login(AuthUserInterface $user): void
    {

    }
}