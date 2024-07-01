<?php

declare(strict_types=1);

namespace App\Twig;

use App\Repository\PostRepository;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

class BlogRuntime implements RuntimeExtensionInterface
{
    public function __construct(private PostRepository $postRepository)
    {
    }

    public function getLatestPosts(Environment $environment, int $number): string
    {
        return $environment->render('parts/latest_blog_posts.html.twig', [
            'latestPosts' => $this->postRepository->getPosts(0, $number),
        ]);
    }
}
