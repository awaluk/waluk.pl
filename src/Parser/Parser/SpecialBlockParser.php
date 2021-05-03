<?php

declare(strict_types=1);

namespace App\Parser\Parser;

use App\Parser\Element\SpecialBlock;
use League\CommonMark\Block\Parser\BlockParserInterface;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

class SpecialBlockParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        if ($cursor->isIndented()) {
            return false;
        }

        if ($cursor->getNextNonSpaceCharacter() !== '[') {
            return false;
        }

        $match = $cursor->match('/^[\s]{0,}\[block:[a-z]+\]/');
        if ($match === null) {
            return false;
        }

        $declaration = explode(':', trim($match));
        $type = substr($declaration[1], 0, -1);
        $context->addBlock(new SpecialBlock($type));

        return true;
    }
}
