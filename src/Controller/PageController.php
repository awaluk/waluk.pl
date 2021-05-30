<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    public function index(PostRepository $postRepository): Response
    {
        $recentPosts = $postRepository->getPosts(0, 3);

        return $this->render('page/index.html.twig', ['recentPosts' => $recentPosts]);
    }

    public function about(): Response
    {
        return $this->render('page/about.html.twig');
    }

    public function contact(): Response
    {
        return $this->render('page/contact.html.twig');
    }

    public function english(): Response
    {
        return $this->render('page/english.html.twig');
    }

    public function privacyPolicy(): Response
    {
        return $this->render('page/privacy-policy.html.twig');
    }

    public function footerPart(CategoryRepository $categoryRepository, bool $showSimple = false): Response
    {
        $categories = $showSimple === false ? $categoryRepository->getCategories() : [];

        return $this->render('page/parts/footer.html.twig', [
            'categories' => $categories,
            'show_simple' => $showSimple
        ]);
    }
}
