<?php

declare(strict_types=1);

namespace Kstptm\FeedReader\Assembler\Item;

class ItemParseConfig
{
    /** @var string */
    public $id;

    /** @var string */
    public $title;

    /** @var string */
    public $date;

    /** @var string */
    public $link;

    /** @var null|string */
    public $image;

    /** @var null|string */
    public $summary;

    public function __construct(string $id, string $title, string $date, string $link)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->link = $link;
    }
}
