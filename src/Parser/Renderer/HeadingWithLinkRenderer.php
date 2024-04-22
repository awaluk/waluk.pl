<?php

declare(strict_types=1);

namespace App\Parser\Renderer;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\Heading;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

class HeadingWithLinkRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false): HtmlElement
    {
        if (!$block instanceof Heading) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

        $tag = 'h' . $block->getLevel();
        $content = $htmlRenderer->renderInlines($block->children());
        $link = $this->prepareLink($content);

        $attrs = $block->getData('attributes', []);
        $attrs['id'] = $link;

        return new HtmlElement(
            $tag,
            $attrs,
            new HtmlElement('a', ['href' => '#' . $link, 'class' => 'content__header-link'], $content)
        );
    }

    private function prepareLink(string $text): string
    {
        $link = mb_strtolower($text);
        $link = str_replace(
            ['ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż'],
            ['a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z'],
            $link
        );
        $link = preg_replace('/[^a-z0-9 ]/', '', $link);
        $link = trim($link);
        $link = str_replace([' ', '--', '---'], '-', $link);

        return $link;
    }
}
