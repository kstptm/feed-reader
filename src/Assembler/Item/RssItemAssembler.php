<?php

declare(strict_types=1);

namespace Kstptm\FeedReader\Assembler\Item;

use DOMElement;
use Exception;
use Kstptm\FeedReader\Exception\ItemAssembleException;
use Kstptm\FeedReader\Feed\Item;

class RssItemAssembler extends AbstractItemAssembler
{
    /**
     * @param DOMElement $element
     *
     * @throws Exception
     * @throws ItemAssembleException
     *
     * @return Item
     */
    public function assemble(DOMElement $element): Item
    {
        $config = new ItemParseConfig(
            'guid',
            'title',
            'pubDate',
            'link'
        );

        $config->image = 'image';

        return $this->assembleFromItemParseResult($this->parse($element, $config));
    }
}
