<?php

declare(strict_types=1);

namespace App\Parser\Renderer;

use App\Parser\Element\Emoji;
use InvalidArgumentException;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class EmojiRenderer implements InlineRendererInterface
{
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer): string
    {
        if (!$inline instanceof Emoji) {
            throw new InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        return sprintf('&#%s;', $inline->getContent());
    }
}
