<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use DateTime;
use SimpleXMLElement;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

readonly class SitemapBuilder
{
    public function __construct(
        private PostRepository $postRepository,
        private CategoryRepository $categoryRepository,
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function build(): string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

        $pages = ['page_index', 'page_about', 'page_contact', 'page_english', 'page_privacy_policy', 'blog_index'];
        foreach ($pages as $page) {
            $item = $xml->addChild('url');
            $item->addChild('loc', $this->urlGenerator->generate($page, [], UrlGeneratorInterface::ABSOLUTE_URL));
            $item->addChild('priority', '1.0');
        }

        $categories = $this->categoryRepository->getCategories();
        foreach ($categories as $category) {
            $item = $xml->addChild('url');
            $item->addChild('loc', $this->urlGenerator->generate('blog_category', [
                'categorySlug' => $category['slug']
            ], UrlGeneratorInterface::ABSOLUTE_URL));
            $item->addChild('priority', '0.9');
        }

        $posts = $this->postRepository->getPosts();
        foreach ($posts as $post) {
            $item = $xml->addChild('url');
            $item->addChild('loc', $this->urlGenerator->generate('blog_post', [
                'categorySlug' => $post['category_slug'],
                'postSlug' => $post['slug']
            ], UrlGeneratorInterface::ABSOLUTE_URL));
            $item->addChild('priority', '0.8');
            $item->addChild('lastmod', (new DateTime($post['date']))->format('Y-m-d'));
        }

        return $xml->asXML();
    }
}
