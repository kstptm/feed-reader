<?php

declare(strict_types=1);

namespace Kstptm\FeedReader\Assembler\Feed;

use DOMDocument;
use Kstptm\FeedReader\Feed\Feed;

interface FeedAssemblerInterface
{
    public function assemble(DOMDocument $document): Feed;
}
