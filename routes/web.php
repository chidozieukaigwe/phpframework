<?php

use App\Controller\DashboardController;
use App\Controller\HomeController;
use App\Controller\LoginController;
use App\Controller\PostsController;
use App\Controller\RegistrationController;
use ChidoUkaigwe\Framework\Http\Middleware\Authenticate;
use ChidoUkaigwe\Framework\Http\Middleware\Dummy;
use ChidoUkaigwe\Framework\Http\Middleware\Guest;
use ChidoUkaigwe\Framework\Http\Response;


return [
    ['GET', '/', [HomeController::class, 'index']],
    ['GET', '/posts/{id:\d+}', [PostsController::class, 'show']],
    ['GET', '/posts', [PostsController::class, 'create']],
    ['POST', '/posts', [PostsController::class, 'store']],
    ['GET', '/register', [RegistrationController::class, 'index',
    [
        Guest::class
    ]]],
    ['POST', '/register', [RegistrationController::class, 'register']],
    ['GET', '/login', [LoginController::class, 'index', [
        Guest::class
    ]]],
    ['POST', '/login', [LoginController::class, 'login']],
    ['GET', '/logout', [LoginController::class, 'logout', [
        Authenticate::class,
    ]]],
    ['GET', '/dashboard', [DashboardController::class, 'index',
    [
        Authenticate::class,
        Dummy::class
    ]
    ]],
    ['GET', '/hello/{name:.+}', function (string $name) {
        return new Response("Hello $name");
    }],
];