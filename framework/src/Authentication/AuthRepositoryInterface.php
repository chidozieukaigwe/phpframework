<?php
namespace ChidoUkaigwe\Framework\Authentication;

interface AuthRepositoryInterface
{
    public function findByUsername(string $username): ?AuthUserInterface;
}