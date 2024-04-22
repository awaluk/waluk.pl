<?php

declare(strict_types=1);

namespace App\Parser\Renderer;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use App\Parser\Element\SpecialBlock;

class SpecialBlockRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false): HtmlElement
    {
        if (!$block instanceof SpecialBlock) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

        $typeClass = 'block block--' . $block->getType();
        $attrs = $block->getData('attributes', []);
        $attrs['class'] = empty($attrs['class']) ? $typeClass : ($typeClass . ' ' . $attrs['class']);

        $filling = $htmlRenderer->renderBlocks($block->children());

        return new HtmlElement('section', $attrs, $filling);
    }
}
