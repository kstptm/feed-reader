<?php

declare(strict_types=1);

namespace Kstptm\FeedReader\Assembler\Item;

use DateTimeImmutable;
use DOMElement;
use DOMNamedNodeMap;
use DOMNode;
use Exception;
use Kstptm\FeedReader\Exception\ItemAssembleException;
use Kstptm\FeedReader\Feed\Item;

abstract class AbstractItemAssembler
{
    abstract public function assemble(DOMElement $element): Item;

    /**
     * @param DOMElement      $element
     * @param ItemParseConfig $config
     *
     * @throws ItemAssembleException
     *
     * @return ItemParseResult
     */
    protected function parse(DOMElement $element, ItemParseConfig $config): ItemParseResult
    {
        $id = $this->getConfiguredValue($element, $config->id);
        $title = $this->getConfiguredValue($element, $config->title);
        $date = $this->getConfiguredValue($element, $config->date);
        $link = $this->getConfiguredValue($element, $config->link);

        if (!is_string($id) || !is_string($title) || !is_string($date) || !is_string($link)) {
            throw new ItemAssembleException('Could not parse feed item');
        }

        $result = new ItemParseResult($id, $title, $date, $link);

        if (is_string($config->image)) {
            $result->image = $this->getConfiguredValue($element, $config->image);
        }

        if (is_string($config->summary)) {
            $result->summary = $this->getConfiguredValue($element, $config->summary);
        }

        return $result;
    }

    protected function getConfiguredValue(DOMElement $element, string $path): ?string
    {
        $pathParts = explode(':', $path);

        if (2 === count($pathParts)) {
            return $this->getChildTagAttribute($element, $pathParts[0], $pathParts[1]);
        }

        return $this->getChildTagValue($element, $path);
    }

    protected function getChildTagValue(DOMElement $element, string $tagName): ?string
    {
        $nodeList = $element->getElementsByTagName($tagName);

        $node = $nodeList->item(0);

        if ($node instanceof DOMNode) {
            return $node->nodeValue;
        }

        return null;
    }

    /**
     * @param ItemParseResult $result
     *
     * @throws Exception
     *
     * @return Item
     */
    protected function assembleFromItemParseResult(ItemParseResult $result): Item
    {
        $item = new Item(
            $result->id,
            $result->title,
            new DateTimeImmutable($result->date),
            $result->link
        );

        if (is_string($result->image)) {
            $item->setImage($result->image);
        }

        if (is_string($result->summary)) {
            $item->setSummary($result->summary);
        }

        return $item;
    }

    protected function getChildTagAttribute(DOMElement $element, string $tagName, string $attributeName): ?string
    {
        $nodeList = $element->getElementsByTagName($tagName);

        $node = $nodeList->item(0);

        if ($node instanceof DOMNode) {
            $attributes = $node->attributes;

            if ($attributes instanceof DOMNamedNodeMap) {
                $attribute = $attributes->getNamedItem($attributeName);

                if ($attribute instanceof DOMNode) {
                    return $attribute->nodeValue;
                }
            }
        }

        return null;
    }
}
