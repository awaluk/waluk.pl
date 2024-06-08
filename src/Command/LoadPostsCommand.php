<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\PostLoader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

#[AsCommand(name: 'app:load:posts')]
class LoadPostsCommand extends Command
{
    public function __construct(private readonly PostLoader $loader, private readonly string $postsPath)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $in = sprintf('%s/*', $this->postsPath);
        $files = (new Finder())->in($in)->exclude('public')->name('*.md')->files();
        foreach ($files as $file) {
            $this->loader->fromFile($file);
        }

        $output->writeln('<info>Loaded all available posts</info>');

        return Command::SUCCESS;
    }
}
