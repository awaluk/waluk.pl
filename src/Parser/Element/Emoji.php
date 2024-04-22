<?php

declare(strict_types=1);

namespace App\Parser\Element;

use League\CommonMark\Inline\Element\AbstractStringContainer;

class Emoji extends AbstractStringContainer
{
    public const array CODES = [
        ':)' => '128578',
        ':(' => '128577',
        ';)' => '128521',
        ':D' => '128516',
        ':P' => '128539',
    ];
}
