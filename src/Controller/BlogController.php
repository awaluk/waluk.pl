<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends AbstractController
{
    private const PER_PAGE = 8;

    public function __construct(private PostRepository $postRepository, private CategoryRepository $categoryRepository)
    {
    }

    public function index(int $page = null): Response
    {
        if ($page === 0 || $page === 1) {
            return $this->redirectToRoute('blog_index', [], 301);
        }
        $count = $this->postRepository->countPosts();
        $paginator = new Paginator($count, $page ?? 1, self::PER_PAGE);
        if ($paginator->getCurrentPage() > $paginator->getTotalPages()) {
            throw $this->createNotFoundException("Page {$paginator->getCurrentPage()} not exists");
        }
        $posts = $this->postRepository->getPosts($paginator->getFromItem(), $paginator->getPerPage());

        return $this->render('blog/index.html.twig', [
            'posts' => $posts,
            'paginator' => $paginator
        ]);
    }

    public function category(string $categorySlug, int $page = null): Response
    {
        $category = $this->categoryRepository->getCategory($categorySlug);
        if ($category === null) {
            throw $this->createNotFoundException("Category '$categorySlug' not exists");
        }
        if ($page === 0 || $page === 1) {
            return $this->redirectToRoute('blog_category', ['categorySlug' => $categorySlug], 301);
        }
        $count = $this->postRepository->countPosts((int)$category['id']);
        $paginator = new Paginator($count, $page ?? 1, self::PER_PAGE);
        if ($paginator->getCurrentPage() > $paginator->getTotalPages()) {
            throw $this->createNotFoundException("Page {$paginator->getCurrentPage()} not exists");
        }
        $posts = $this->postRepository->getPosts(
            $paginator->getFromItem(),
            $paginator->getPerPage(),
            (int)$category['id']
        );

        return $this->render('blog/category.html.twig', [
            'posts' => $posts,
            'category' => $category,
            'paginator' => $paginator
        ]);
    }

    public function post(string $categorySlug, string $postSlug): Response
    {
        $category = $this->categoryRepository->getCategory($categorySlug);
        if ($category === null) {
            throw $this->createNotFoundException("Category '$categorySlug' not exists");
        }
        $post = $this->postRepository->getPost($postSlug, (int)$category['id']);
        if ($post === null) {
            throw $this->createNotFoundException("Post '$postSlug' not exists");
        }

        return $this->render('blog/post.html.twig', [
            'category' => $category,
            'post' => $post
        ]);
    }

    public function navPart(): Response
    {
        $categories = $this->categoryRepository->getCategories();

        return $this->render('blog/parts/nav.html.twig', [
            'categories' => $categories
        ]);
    }

    public function sidebarPart(): Response
    {
        $recentPosts = $this->postRepository->getPosts(0, 3);

        return $this->render('blog/parts/sidebar.html.twig', [
            'recentPosts' => $recentPosts
        ]);
    }
}
