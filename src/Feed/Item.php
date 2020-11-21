<?php

declare(strict_types=1);

namespace Kstptm\FeedReader\Feed;

use DateTimeImmutable;

class Item
{
    /** @var string */
    private $id;

    /** @var string */
    private $title;

    /** @var DateTimeImmutable */
    private $date;

    /** @var string */
    private $link;

    /** @var null|string */
    private $summary;

    /** @var null|string */
    private $image;

    public function __construct(string $id, string $title, DateTimeImmutable $date, string $link)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->link = $link;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setSummary(string $summary): void
    {
        $this->summary = $summary;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }
}
