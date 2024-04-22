<?php

declare(strict_types=1);

namespace App\Parser;

use App\Parser\Element\Emoji;
use App\Parser\Element\SpecialBlock;
use App\Parser\Parser\EmojiParser;
use App\Parser\Parser\SpecialBlockParser;
use App\Parser\Renderer\EmojiRenderer;
use App\Parser\Renderer\HeadingWithLinkRenderer;
use App\Parser\Renderer\SmallCodeRenderer;
use App\Parser\Renderer\SpecialBlockRenderer;
use League\CommonMark\Block\Element\Heading;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Inline\Element\Code;

class ParserFactory
{
    public static function createCommonMark(array $config): CommonMarkConverter
    {
        $environment = Environment::createCommonMarkEnvironment();

        $environment->addExtension(new ExternalLinkExtension());

        $environment->addBlockParser(new SpecialBlockParser());
        $environment->addInlineParser(new EmojiParser());

        $environment->addInlineRenderer(Code::class, new SmallCodeRenderer());
        $environment->addInlineRenderer(Emoji::class, new EmojiRenderer());
        $environment->addBlockRenderer(SpecialBlock::class, new SpecialBlockRenderer());
        $environment->addBlockRenderer(Heading::class, new HeadingWithLinkRenderer());

        return new CommonMarkConverter($config, $environment);
    }
}
