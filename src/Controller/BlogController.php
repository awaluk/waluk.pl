<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends AbstractController
{
    public function __construct(private PostRepository $postRepository, private CategoryRepository $categoryRepository)
    {
    }

    public function index(): Response
    {
        $posts = $this->postRepository->getPosts();

        return $this->render('blog/index.html.twig', ['posts' => $posts]);
    }

    public function category(string $categorySlug): Response
    {
        $category = $this->categoryRepository->getCategory($categorySlug);
        if ($category === null) {
            throw $this->createNotFoundException();
        }
        $posts = $this->postRepository->getPosts((int)$category['id']);

        return $this->render('blog/category.html.twig', ['posts' => $posts]);
    }

    public function post(string $categorySlug, string $postSlug): Response
    {
        $category = $this->categoryRepository->getCategory($categorySlug);
        if ($category === null) {
            throw $this->createNotFoundException();
        }
        $post = $this->postRepository->getPost($postSlug, (int)$category['id']);
        if ($post === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('blog/post.html.twig', [
            'category' => $category,
            'post' => $post
        ]);
    }
}
