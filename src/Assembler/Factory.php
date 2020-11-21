<?php

declare(strict_types=1);

namespace Kstptm\FeedReader\Assembler;

use DOMDocument;
use DOMElement;
use Kstptm\FeedReader\Assembler\Feed\AtomFeedAssembler;
use Kstptm\FeedReader\Assembler\Feed\FeedAssemblerInterface;
use Kstptm\FeedReader\Assembler\Feed\RssFeedAssembler;
use Kstptm\FeedReader\Exception\UnknownFeedTypeException;

class Factory
{
    /**
     * @param DOMDocument $document
     *
     * @throws UnknownFeedTypeException
     *
     * @return FeedAssemblerInterface
     */
    public static function build(DOMDocument $document): FeedAssemblerInterface
    {
        if (self::isRss($document)) {
            return new RssFeedAssembler();
        }

        if (self::isAtom($document)) {
            return new AtomFeedAssembler();
        }

        throw new UnknownFeedTypeException('Could not identify feed type');
    }

    public static function isRss(DOMDocument $document): bool
    {
        $element = $document->documentElement;

        if ($element instanceof DOMElement) {
            return 'rss' === $element->tagName;
        }

        return false;
    }

    public static function isAtom(DOMDocument $document): bool
    {
        $element = $document->documentElement;

        if ($element instanceof DOMElement) {
            return 'http://www.w3.org/2005/Atom' === $element->namespaceURI;
        }

        return false;
    }
}
