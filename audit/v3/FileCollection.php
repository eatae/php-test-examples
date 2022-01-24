<?php

namespace Audit\V3;

use Audit\V3\Interfaces\ItemCollection;
use Audit\V3\Interfaces\Item;
use Audit\V3\Interfaces\ItemSpecifier;

class FileCollection extends BaseItemCollection
{
    public function getLastFile(): FileContent
    {
        sort($this->items);
        return $this->items[array_key_last($this->items)];
    }
}