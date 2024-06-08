<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;

readonly class DeployService
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
        private PostLoader $postLoader,
        private BlogRSSBuilder $blogRSSBuilder,
        private SitemapBuilder $sitemapBuilder
    ) {
    }

    public function prepareContent(): void
    {
        $in = sprintf('%s/*', $this->parameterBag->get('posts_path'));
        $files = (new Finder())->in($in)->exclude('public')->name('*.md')->files();
        foreach ($files as $file) {
            $this->postLoader->fromFile($file);
        }

        $rssXml = $this->blogRSSBuilder->build();
        file_put_contents($this->parameterBag->get('blog_rss_path'), $rssXml);

        $sitemapXml = $this->sitemapBuilder->build();
        file_put_contents($this->parameterBag->get('sitemap_path'), $sitemapXml);
    }
}
