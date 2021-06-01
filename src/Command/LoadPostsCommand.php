<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\PostLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class LoadPostsCommand extends Command
{
    protected static $defaultName = 'app:load-posts';

    public function __construct(private PostLoader $loader)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $files = (new Finder())->in('posts/*')->exclude('public')->name('*.md')->files();
        foreach ($files as $file) {
            $this->loader->fromFile($file);
        }

        $output->writeln('<info>Loaded all available posts</info>');

        return Command::SUCCESS;
    }
}
