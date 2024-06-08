<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\SitemapBuilder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:build:sitemap')]
class BuildSitemapCommand extends Command
{
    public function __construct(private readonly SitemapBuilder $sitemapBuilder, private readonly string $sitemapPath) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $xml = $this->sitemapBuilder->build();
        file_put_contents($this->sitemapPath, $xml);
        $output->writeln('<info>Sitemap generated!</info>');

        return Command::SUCCESS;
    }
}
