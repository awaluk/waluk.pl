<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\BlogRSSBuilder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:build:blog-rss')]
class BuildBlogRSSCommand extends Command
{
    public function __construct(
        private readonly BlogRSSBuilder $blogRSSBuilder,
        private readonly string $blogRSSPath
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $xml = $this->blogRSSBuilder->build();
        file_put_contents($this->blogRSSPath, $xml);
        $output->writeln('<info>RSS file generated!</info>');

        return Command::SUCCESS;
    }
}
