<?php

use App\Controller\HomeController;
use App\Controller\PostsController;
use App\Controller\RegistrationController;
use ChidoUkaigwe\Framework\Http\Response;


return [
    ['GET', '/', [HomeController::class, 'index']],
    ['GET', '/posts/{id:\d+}', [PostsController::class, 'show']],
    ['GET', '/posts', [PostsController::class, 'create']],
    ['POST', '/posts', [PostsController::class, 'store']],
    ['GET', '/register', [RegistrationController::class, 'index']],
    ['POST', '/register', [RegistrationController::class, 'register']],
    ['GET', '/hello/{name:.+}', function (string $name) {
        return new Response("Hello $name");
    }],
];