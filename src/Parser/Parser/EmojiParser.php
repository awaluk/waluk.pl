<?php

declare(strict_types=1);

namespace App\Parser\Parser;

use App\Parser\Element\Emoji;
use League\CommonMark\Inline\Element\HtmlInline;
use League\CommonMark\Inline\Element\Text;
use League\CommonMark\Inline\Parser\InlineParserInterface;
use League\CommonMark\InlineParserContext;

class EmojiParser implements InlineParserInterface
{
    public function getCharacters(): array
    {
        return [':', ';'];
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();

        $previousChar = $cursor->peek(-1);
        $afterChar = $cursor->peek(2);
        if (($previousChar !== null && $previousChar !== ' ') || ($afterChar !== null && $afterChar !== ' ')) {
            return false;
        }

        $emoji = $cursor->getCharacter() . $cursor->peek();
        if (!array_key_exists($emoji, Emoji::CODES)) {
            return false;
        }

        $cursor->advanceBy(2);
        $inlineContext->getContainer()->appendChild(new Emoji(Emoji::CODES[$emoji]));

        return true;
    }
}
