<?php

declare(strict_types=1);

namespace App\Parser\Renderer;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Code;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use League\CommonMark\Util\Xml;

class SmallCodeRenderer implements InlineRendererInterface
{
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer): HtmlElement
    {
        if (!$inline instanceof Code) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        $attrs = $inline->getData('attributes', []);
        $attrs['class'] = empty($attrs['class']) ? 'inline-code' : ('inline-code ' . $attrs['class']);

        return new HtmlElement('code', $attrs, Xml::escape($inline->getContent()));
    }
}
