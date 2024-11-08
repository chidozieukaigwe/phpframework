<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostMapper;
use App\Repository\PostRepository;
use ChidoUkaigwe\Framework\Controller\AbstractController;
use ChidoUkaigwe\Framework\Http\RedirectResponse;
use ChidoUkaigwe\Framework\Http\Response;
use ChidoUkaigwe\Framework\Session\SessionInterface;

class PostsController extends AbstractController
{
    public function __construct(
        private PostMapper $postMapper,
        private PostRepository $postRepository,
        )
    {

    }

    public function show(int $id): Response
    {
        $post = $this->postRepository->findOrFail($id);

       return $this->render('post.html.twig', ['post' => $post]);
    }

    public function create(): Response
    {
        return $this->render('create-post.html.twig');
    }

    public function store(): Response
    {
        $title = $this->request->postParams['title'];
        $body = $this->request->postParams['body'];

        $post = Post::create($title, $body);

        $this->postMapper->save($post);

        $this->request->getSession()->setFlash('success', sprintf('Post "%s" created successfully', $title));

       return new RedirectResponse('/posts');

    }   
}