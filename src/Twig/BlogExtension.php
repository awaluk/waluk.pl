<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BlogExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('render_latest_posts', [BlogRuntime::class, 'getLatestPosts'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
        ];
    }
}
