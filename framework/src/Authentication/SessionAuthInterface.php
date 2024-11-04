<?php
namespace ChidoUkaigwe\Framework\Authentication;

interface SessionAuthInterface
{
    public function authenticate(string $username, string $password): bool;

    public function getUser():AuthUserInterface;

    public function logout(): void;

    public function login(AuthUserInterface $user);
}