<?php

declare(strict_types=1);

namespace Kstptm\FeedReader\Feed;

class Feed
{
    /** @var array Item */
    private $items = [];

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }
}
