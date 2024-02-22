<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\PostRepository;
use DateTime;
use SimpleXMLElement;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsCommand(name: 'app:build:blog-rss')]
class BuildBlogRSSCommand extends Command
{
    public function __construct(
        private PostRepository $postRepository,
        private UrlGeneratorInterface $urlGenerator,
        private ParameterBagInterface $parameterBag
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $pageUrl = $this->urlGenerator->generate('page_index', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"></rss>');
        $channel = $xml->addChild('channel');
        $channel->addChild('title', 'Arkadiusz Waluk - blog');
        $channel->addChild('description', 'Blog informatyczny Arkadiusza Waluka');
        $channel->addChild('link', $pageUrl);
        $channel->addChild('language', 'pl');
        $channel->addChild('copyright', 'Arkadiusz Waluk');
        $channel->addChild('lastBuildDate', (new DateTime())->format('r'));

        $posts = $this->postRepository->getPosts(0, 20);
        foreach ($posts as $post) {
            $postUrl = $this->urlGenerator->generate('blog_post', [
                'categorySlug' => $post['category_slug'],
                'postSlug' => $post['slug']
            ], UrlGeneratorInterface::ABSOLUTE_URL);
            $item = $channel->addChild('item');
            $item->addChild('title', $post['title']);
            $item->addChild('description', $post['title']);
            $item->addChild('category', $post['category_name']);
            $item->addChild('pubDate', (new DateTime($post['date']))->format('r'));
            $item->addChild('author', 'Arkadiusz Waluk');
            $item->addChild('link', $postUrl);
            $item->addChild('guid', $postUrl);
        }

        file_put_contents($this->parameterBag->get('kernel.project_dir') . '/public/blog-rss.xml', $xml->asXML());
        $output->writeln('<info>RSS file generated!</info>');

        return Command::SUCCESS;
    }
}
