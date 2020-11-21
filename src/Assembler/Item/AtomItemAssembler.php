<?php

declare(strict_types=1);

namespace Kstptm\FeedReader\Assembler\Item;

use DOMElement;
use Exception;
use Kstptm\FeedReader\Exception\ItemAssembleException;
use Kstptm\FeedReader\Feed\Item;

class AtomItemAssembler extends AbstractItemAssembler
{
    /**
     * @param DOMElement $element
     *
     * @throws ItemAssembleException
     * @throws Exception
     *
     * @return Item
     */
    public function assemble(DOMElement $element): Item
    {
        $config = new ItemParseConfig(
            'id',
            'title',
            'updated',
            'link:href'
        );

        $config->summary = 'summary';

        return $this->assembleFromItemParseResult($this->parse($element, $config));
    }
}
