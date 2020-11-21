<?php

declare(strict_types=1);

namespace Kstptm\FeedReader\Assembler\Feed;

use DOMDocument;
use Kstptm\FeedReader\Assembler\Item\AtomItemAssembler;
use Kstptm\FeedReader\Exception\ItemAssembleException;
use Kstptm\FeedReader\Feed\Feed;

class AtomFeedAssembler implements FeedAssemblerInterface
{
    /** @var AtomItemAssembler */
    private $itemAssembler;

    public function __construct()
    {
        $this->itemAssembler = new AtomItemAssembler();
    }

    /**
     * @param DOMDocument $document
     *
     * @throws ItemAssembleException
     *
     * @return Feed
     */
    public function assemble(DOMDocument $document): Feed
    {
        $feed = new Feed();

        foreach ($document->getElementsByTagName('entry') as $itemNode) {
            $feed->addItem($this->itemAssembler->assemble($itemNode));
        }

        return $feed;
    }
}
