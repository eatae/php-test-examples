<?php

namespace Audit\V3;

use Audit\V3\Interfaces\Item;
use Audit\V3\Interfaces\ItemSpecifier;

class FileContentSpecifier implements ItemSpecifier
{
    public function isValid(Item $item): bool
    {
        return $item instanceof FileContent;
    }
}