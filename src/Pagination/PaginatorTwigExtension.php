<?php

declare(strict_types=1);

namespace App\Pagination;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PaginatorTwigExtension extends AbstractExtension
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('page_path', [$this, 'getPagePath'])
        ];
    }

    public function getPagePath(int $page, string $categorySlug = null): string
    {
        if ($categorySlug === null) {
            if ($page <= 1) {
                return $this->urlGenerator->generate('blog_index');
            }

            return $this->urlGenerator->generate('blog_index_page', ['page' => $page]);
        }

        if ($page <= 1) {
            return $this->urlGenerator->generate('blog_category', ['categorySlug' => $categorySlug]);
        }

        return $this->urlGenerator->generate('blog_category_page', ['categorySlug' => $categorySlug, 'page' => $page]);
    }
}
