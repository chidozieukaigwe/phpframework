<?php

use App\Controller\HomeController;
use App\Controller\PostsController;
use ChidoUkaigwe\Framework\Http\Response;

return [
    ['GET', '/', [HomeController::class, 'index']],
    ['GET', '/posts/{id:\d+}', [PostsController::class, 'show']],
    ['GET', '/posts', [PostsController::class, 'create']],
    ['GET', '/hello/{name:.+}', function (string $name) {
        return new Response("Hello $name");
    }],
];